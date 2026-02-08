<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Stream;
use App\Notifications\NewStreamAdded;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class StreamController extends Controller
{
    public function index()
    {
        $streams = Stream::latest()->get();
        return view('admin.streams.index', compact('streams'));
    }

    public function create()
    {
        return view('admin.streams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stream_url' => 'required|string',
            'format' => 'required|in:url,hls,rtmp',
            'type' => 'required|in:live,recorded',
            'scheduled_at' => 'nullable|date'
        ]);

        $stream = Stream::create($request->all());

        // Notify all users
        $usersToNotify = User::where('id', '!=', auth()->id())->get();
        Notification::send($usersToNotify, new NewStreamAdded($stream));

        return redirect()->route('admin.streams')->with('success', 'Stream created and users notified successfully');
    }

    public function edit($id)
    {
        $stream = Stream::findOrFail($id);
        return view('admin.streams.edit', compact('stream'));
    }

    public function update(Request $request, $id)
    {
        $stream = Stream::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stream_url' => 'required|string',
            'format' => 'required|in:url,hls,rtmp',
            'type' => 'required|in:live,recorded',
            'scheduled_at' => 'nullable|date'
        ]);

        $stream->update($request->all());

        return redirect()->route('admin.streams')->with('success', 'Stream updated successfully');
    }

    public function destroy(Request $request)
    {
        $stream = Stream::findOrFail($request->id);
        $stream->delete();

        return response()->json(['success' => true, 'message' => 'Stream deleted successfully']);
    }
}