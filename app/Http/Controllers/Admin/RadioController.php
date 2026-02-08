<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Radio;
use App\Models\RadioSchedule;
use App\Notifications\NewRadioAdded;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class RadioController extends Controller
{
    public function index()
    {
        $radios = Radio::orderBy('sort_order')->get();
        return view('admin.radios.index', compact('radios'));
    }

    public function create()
    {
        return view('admin.radios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stream_url' => 'required|string',
            'genre' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer'
        ]);

        $radio = Radio::create($request->all());

        // Create schedules if provided
        if ($request->has('schedules')) {
            foreach ($request->schedules as $schedule) {
                if (!empty($schedule['day_of_week']) && !empty($schedule['start_time']) && !empty($schedule['end_time'])) {
                    RadioSchedule::create([
                        'radio_id' => $radio->id,
                        'day_of_week' => $schedule['day_of_week'],
                        'start_time' => $schedule['start_time'],
                        'end_time' => $schedule['end_time'],
                        'program_name' => $schedule['program_name'] ?? null,
                        'host_name' => $schedule['host_name'] ?? null
                    ]);
                }
            }
        }

        // Notify all users
        $usersToNotify = User::where('id', '!=', auth()->id())->get();
        Notification::send($usersToNotify, new NewRadioAdded($radio));

        return redirect()->route('admin.radios')->with('success', 'Radio station created successfully');
    }

    public function edit($id)
    {
        $radio = Radio::findOrFail($id);
        return view('admin.radios.edit', compact('radio'));
    }

    public function update(Request $request, $id)
    {
        $radio = Radio::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stream_url' => 'required|string',
            'genre' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer'
        ]);

        $radio->update($request->all());

        return redirect()->route('admin.radios')->with('success', 'Radio station updated successfully');
    }

    public function destroy(Request $request)
    {
        $radio = Radio::findOrFail($request->id);
        
        // Delete associated schedules first (if table exists)
        try {
            $radio->schedules()->delete();
        } catch (\Exception $e) {
            // Table doesn't exist yet, skip schedule deletion
        }
        
        $radio->delete();

        return response()->json(['success' => true, 'message' => 'Radio station deleted successfully']);
    }
}