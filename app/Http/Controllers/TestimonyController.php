<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimony;

class TestimonyController extends Controller
{
    public function index() {
        $testimonies = Testimony::where('allow_publish', 1)->latest()->take(10)->get();
        return view('front.testimony', compact('testimonies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'location' => 'nullable|string|max:255',
            'category' => 'required|string',
            'title' => 'required|string|max:255',
            'testimony' => 'required|string',
            'allow_publish' => 'nullable|boolean'
        ]);

        Testimony::create([
            'name' => $request->name,
            'email' => $request->email,
            'location' => $request->location,
            'category' => $request->category,
            'title' => $request->title,
            'testimony' => $request->testimony,
            'allow_publish' => $request->has('allow_publish')
        ]);

        return back()->with('success', 'Thank you for sharing your testimony! It has been submitted successfully.');
    }
}
