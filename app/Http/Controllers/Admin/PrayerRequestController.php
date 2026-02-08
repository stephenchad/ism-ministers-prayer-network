<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrayerRequest;

class PrayerRequestController extends Controller
{
      public function index()
      {
            $prayerRequests = PrayerRequest::latest()->paginate(20);
            return view('admin.prayer-requests.index', compact('prayerRequests'));
      }

      public function edit($id)
      {
            $prayerRequest = PrayerRequest::findOrFail($id);
            return view('admin.prayer-requests.edit', compact('prayerRequest'));
      }

      public function update(Request $request, $id)
      {
            $prayerRequest = PrayerRequest::findOrFail($id);
            
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'prayer_type' => 'required|string|max:255',
                'request' => 'required|string',
                'status' => 'required|in:pending,approved,rejected',
            ]);

            $prayerRequest->update([
                'name' => $request->name,
                'email' => $request->email,
                'prayer_type' => $request->prayer_type,
                'prayer_request' => $request->input('request'), // Use input() method to avoid conflict
                'status' => $request->status,
            ]);

            return redirect()->route('admin.prayer-requests.index')
                ->with('success', 'Prayer request updated successfully.');
      }

      public function approve($id)
      {
            $prayerRequest = PrayerRequest::findOrFail($id);
            $prayerRequest->update(['status' => 'approved']);
            return redirect()->back()->with('success', 'Prayer request approved.');
      }

      public function reject($id)
      {
            $prayerRequest = PrayerRequest::findOrFail($id);
            $prayerRequest->update(['status' => 'rejected']);
            return redirect()->back()->with('success', 'Prayer request rejected.');
      }

      public function destroy($id)
      {
            $prayerRequest = PrayerRequest::findOrFail($id);
            $prayerRequest->delete();
            return redirect()->back()->with('success', 'Prayer request deleted successfully.');
      }
}
