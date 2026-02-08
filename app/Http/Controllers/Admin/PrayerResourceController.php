<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PrayerResource;
use App\Notifications\NewPrayerResourceAdded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Exceptions\PostTooLargeException;

class PrayerResourceController extends Controller
{
    public function index()
    {
        $resources = PrayerResource::orderBy('sort_order')->get();
        return view('admin.prayer-resources.index', compact('resources'));
    }

    public function create()
    {
        return view('admin.prayer-resources.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'resource_type' => 'required|in:file,video,guide',
            'sort_order' => 'nullable|integer'
        ];

        if ($request->resource_type === 'file') {
            $rules['file'] = 'required|file|mimes:pdf,doc,docx|max:10240';
        } elseif ($request->resource_type === 'video') {
            $rules['video_url'] = 'required_without:video_file|nullable|url';
            $rules['video_file'] = 'required_without:video_url|nullable|file|mimes:mp4,avi,mov,wmv|max:102400';
            $rules['duration'] = 'nullable|string|max:255';
        } else {
            $rules['guide_content'] = 'required|string';
            $rules['reading_time'] = 'nullable|string|max:255';
            $rules['icon'] = 'nullable|string|max:255';
        }

        $request->validate($rules);
        $data = $request->all();

        if ($request->resource_type === 'file' && $request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Ensure directory exists
            $directory = public_path('assets/prayer-resources');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $file->move($directory, $fileName);
            $data['file_path'] = 'assets/prayer-resources/' . $fileName;

            try {
                $fileSize = $file->getSize();
                $data['file_size'] = $this->formatBytes($fileSize);
            } catch (\Exception $e) {
                // If getting file size fails, set a default size
                $data['file_size'] = 'Unknown';
            }

            $data['file_type'] = $file->getClientOriginalExtension();
        } elseif ($request->resource_type === 'video' && $request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Ensure videos directory exists
            $directory = public_path('assets/videos');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $file->move($directory, $fileName);
            $data['video_file'] = 'assets/videos/' . $fileName;
        }

        $resource = PrayerResource::create($data);

        // Notify all users
        $usersToNotify = User::where('id', '!=', auth()->id())->get();
        Notification::send($usersToNotify, new NewPrayerResourceAdded($resource));

        return redirect()->route('admin.prayer-resources')->with('success', 'Prayer resource created and users notified successfully');
    }

    public function edit($id)
    {
        $resource = PrayerResource::findOrFail($id);
        return view('admin.prayer-resources.edit', compact('resource'));
    }

    public function update(Request $request, $id)
    {
        $resource = PrayerResource::findOrFail($id);

        // Base validation rules for all resource types
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sort_order' => 'nullable|integer'
        ];

        // Add resource type specific validation rules
        if ($resource->resource_type === 'file') {
            $rules['file'] = 'nullable|file|mimes:pdf,doc,docx|max:10240';
        } elseif ($resource->resource_type === 'video') {
            $rules['video_url'] = 'nullable|url';
            $rules['video_file'] = 'nullable|file|mimes:mp4,avi,mov,wmv|max:102400';
            $rules['duration'] = 'nullable|string|max:255';
        } elseif ($resource->resource_type === 'guide') {
            $rules['guide_content'] = 'required|string';
            $rules['reading_time'] = 'nullable|string|max:255';
            $rules['icon'] = 'nullable|string|max:255';
        }

        $request->validate($rules);
        $data = $request->all();

        // Handle file upload for file resources
        if ($resource->resource_type === 'file' && $request->hasFile('file')) {
            if ($resource->file_path && File::exists(public_path($resource->file_path))) {
                File::delete(public_path($resource->file_path));
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Ensure directory exists
            $directory = public_path('assets/prayer-resources');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $file->move($directory, $fileName);
            $data['file_path'] = 'assets/prayer-resources/' . $fileName;

            try {
                $fileSize = $file->getSize();
                $data['file_size'] = $this->formatBytes($fileSize);
            } catch (\Exception $e) {
                // If getting file size fails, set a default size
                $data['file_size'] = 'Unknown';
            }

            $data['file_type'] = $file->getClientOriginalExtension();
        }

        // Handle video file upload for video resources
        if ($resource->resource_type === 'video' && $request->hasFile('video_file')) {
            if ($resource->video_file && File::exists(public_path($resource->video_file))) {
                File::delete(public_path($resource->video_file));
            }

            $file = $request->file('video_file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Ensure videos directory exists
            $directory = public_path('assets/videos');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $file->move($directory, $fileName);
            $data['video_file'] = 'assets/videos/' . $fileName;
        }

        $resource->update($data);

        return redirect()->route('admin.prayer-resources')->with('success', 'Prayer resource updated successfully');
    }

    public function destroy(Request $request)
    {
        $resource = PrayerResource::findOrFail($request->id);

        if ($resource->file_path && File::exists(public_path($resource->file_path))) {
            File::delete(public_path($resource->file_path));
        }

        $resource->delete();

        return response()->json(['success' => true, 'message' => 'Prayer resource deleted successfully']);
    }

    private function formatBytes($size, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB');

        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }

        return round($size, $precision) . ' ' . $units[$i];
    }
}