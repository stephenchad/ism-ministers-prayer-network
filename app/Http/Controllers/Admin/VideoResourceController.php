<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\VideoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VideoResourceController extends Controller
{
    public function index()
    {
        $videos = VideoResource::orderBy('sort_order')->get();
        return view('admin.video-resources.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.video-resources.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_type' => 'required|in:url,file',
            'video_url' => 'required_if:video_type,url|nullable|url',
            'video_file' => 'required_if:video_type,file|nullable|file|mimes:mp4,avi,mov,wmv|max:102400',
            'duration' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer'
        ]);

        $data = $request->all();
        
        if ($request->video_type === 'file' && $request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/videos'), $fileName);
            $data['video_file'] = 'assets/videos/' . $fileName;
        }

        VideoResource::create($data);

        return redirect()->route('admin.video-resources')->with('success', 'Video resource created successfully');
    }

    public function edit($id)
    {
        $video = VideoResource::findOrFail($id);
        return view('admin.video-resources.edit', compact('video'));
    }

    public function update(Request $request, $id)
    {
        $video = VideoResource::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_type' => 'required|in:url,file',
            'video_url' => 'required_if:video_type,url|nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:102400',
            'duration' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer'
        ]);

        $data = $request->all();
        
        if ($request->video_type === 'file' && $request->hasFile('video_file')) {
            if ($video->video_file && File::exists(public_path($video->video_file))) {
                File::delete(public_path($video->video_file));
            }
            
            $file = $request->file('video_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/videos'), $fileName);
            $data['video_file'] = 'assets/videos/' . $fileName;
        }

        $video->update($data);

        return redirect()->route('admin.video-resources')->with('success', 'Video resource updated successfully');
    }

    public function destroy(Request $request)
    {
        $video = VideoResource::findOrFail($request->id);
        
        if ($video->video_file && File::exists(public_path($video->video_file))) {
            File::delete(public_path($video->video_file));
        }
        
        $video->delete();

        return response()->json(['success' => true, 'message' => 'Video resource deleted successfully']);
    }
}