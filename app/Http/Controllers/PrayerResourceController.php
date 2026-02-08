<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PrayerResource;

class PrayerResourceController extends Controller
{
    public function index()
    {
        $resources = PrayerResource::where('resource_type', 'file')
            ->orderBy('sort_order')
            ->get();
        $videos = PrayerResource::where('resource_type', 'video')
            ->orderBy('sort_order')
            ->get();
        $guides = PrayerResource::where('resource_type', 'guide')
            ->orderBy('sort_order')
            ->get();
        return view('front.prayer-resources', compact('resources', 'videos', 'guides'));
    }

    public function download($id)
    {
        $resource = PrayerResource::where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        $filePath = public_path($resource->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'Resource file not found');
        }

        return response()->download($filePath, $resource->title . '.' . $resource->file_type);
    }
}