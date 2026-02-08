<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrayerRequest;
use App\Models\PrayerType;

class PrayersController extends Controller
{
    public function index()
    {
        $prayerRequests = PrayerRequest::where('status', 'approved')->latest()->take(10)->get();
        $prayerTypes = PrayerType::all();
        return view('front.prayers', compact('prayerRequests', 'prayerTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'prayer_type' => 'required|string',
            'prayer_request' => 'required|string',
            'language' => 'required|in:en,es,fr,zh,ar'
        ]);

        PrayerRequest::create([
            'name' => $request->name,
            'email' => $request->email,
            'prayer_type' => $request->prayer_type,
            'prayer_request' => $request->prayer_request,
            'language' => $request->language
        ]);

        return back()->with('success', 'Your prayer request has been submitted. Our prayer team will lift you up in prayer.');
    }
}
