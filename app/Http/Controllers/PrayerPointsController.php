<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrayerPoint;

class PrayerPointsController extends Controller
{
    public function index()
    {
        $prayerPoints = PrayerPoint::where('status', 'approved')->latest()->paginate(10);
        return view('front.prayer-points', compact('prayerPoints'));
    }

    public function show($id)
    {
        $prayerPoint = PrayerPoint::where('status', 'approved')->findOrFail($id);
        return view('front.prayer-points.show', compact('prayerPoint'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('account.login')->with('error', 'Please log in to submit a prayer point.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'language' => 'required|in:en,es,fr,zh,ar'
        ]);

        $data = [
            'user_id' => auth()->id(),
            'status' => 'pending',
            'language' => $request->language
        ];

        switch ($request->language) {
            case 'en':
                $data['title'] = $request->title;
                $data['content'] = $request->content;
                break;
            case 'es':
                $data['title_es'] = $request->title;
                $data['content_es'] = $request->content;
                break;
            case 'fr':
                $data['title_fr'] = $request->title;
                $data['content_fr'] = $request->content;
                break;
            case 'zh':
                $data['title_zh'] = $request->title;
                $data['content_zh'] = $request->content;
                break;
            case 'ar':
                $data['title_ar'] = $request->title;
                $data['content_ar'] = $request->content;
                break;
        }

        PrayerPoint::create($data);

        return back()->with('success', 'Your prayer point has been submitted for review.');
    }
}
