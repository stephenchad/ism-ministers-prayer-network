<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrayerPoint;

class PrayerPointController extends Controller
{
    public function index()
    {
        $prayerPoints = PrayerPoint::latest()->paginate(20);
        return view('admin.prayer-points.index', compact('prayerPoints'));
    }

    public function approve($id)
    {
        $prayerPoint = PrayerPoint::findOrFail($id);
        $prayerPoint->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Prayer point approved.');
    }

    public function reject($id)
    {
        $prayerPoint = PrayerPoint::findOrFail($id);
        $prayerPoint->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Prayer point rejected.');
    }

    public function destroy($id)
    {
        $prayerPoint = PrayerPoint::findOrFail($id);
        $prayerPoint->delete();
        return redirect()->back()->with('success', 'Prayer point deleted successfully.');
    }

    public function create()
    {
        return view('admin.prayer-points.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'title_es' => 'nullable|string|max:255',
            'content_es' => 'nullable|string',
            'title_fr' => 'nullable|string|max:255',
            'content_fr' => 'nullable|string',
            'title_zh' => 'nullable|string|max:255',
            'content_zh' => 'nullable|string',
            'title_ar' => 'nullable|string|max:255',
            'content_ar' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['status'] = 'approved';

        PrayerPoint::create($data);

        return redirect()->route('admin.prayer-points.index')->with('success', 'Prayer point created successfully.');
    }

    public function edit($id)
    {
        $prayerPoint = PrayerPoint::findOrFail($id);
        return view('admin.prayer-points.edit', compact('prayerPoint'));
    }

    public function update(Request $request, $id)
    {
        $prayerPoint = PrayerPoint::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'title_es' => 'nullable|string|max:255',
            'content_es' => 'nullable|string',
            'title_fr' => 'nullable|string|max:255',
            'content_fr' => 'nullable|string',
            'title_zh' => 'nullable|string|max:255',
            'content_zh' => 'nullable|string',
            'title_ar' => 'nullable|string|max:255',
            'content_ar' => 'nullable|string',
        ]);

        $prayerPoint->update($request->all());

        return redirect()->route('admin.prayer-points.index')->with('success', 'Prayer point updated successfully.');
    }
}
