<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\WorshipMusic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class WorshipMusicController extends Controller
{
    public function index()
    {
        $music = WorshipMusic::orderBy('sort_order')->get();
        return view('admin.worship-music.index', compact('music'));
    }

    public function create()
    {
        return view('admin.worship-music.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'music_type' => 'required|in:streaming,download',
            'file' => 'required|file|mimes:mp3,wav,m4a|max:51200',
            'duration' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/worship-music'), $fileName);
            $data['file_path'] = 'assets/worship-music/' . $fileName;
            $data['file_size'] = $this->formatBytes($file->getSize());
        }

        WorshipMusic::create($data);

        return redirect()->route('admin.worship-music')->with('success', 'Worship music added successfully');
    }

    public function edit($id)
    {
        $music = WorshipMusic::findOrFail($id);
        return view('admin.worship-music.edit', compact('music'));
    }

    public function update(Request $request, $id)
    {
        $music = WorshipMusic::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'music_type' => 'required|in:streaming,download',
            'file' => 'nullable|file|mimes:mp3,wav,m4a|max:51200',
            'duration' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('file')) {
            if ($music->file_path && File::exists(public_path($music->file_path))) {
                File::delete(public_path($music->file_path));
            }
            
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/worship-music'), $fileName);
            $data['file_path'] = 'assets/worship-music/' . $fileName;
            $data['file_size'] = $this->formatBytes($file->getSize());
        }

        $music->update($data);

        return redirect()->route('admin.worship-music')->with('success', 'Worship music updated successfully');
    }

    public function destroy(Request $request)
    {
        $music = WorshipMusic::findOrFail($request->id);
        
        if ($music->file_path && File::exists(public_path($music->file_path))) {
            File::delete(public_path($music->file_path));
        }
        
        $music->delete();

        return response()->json(['success' => true, 'message' => 'Worship music deleted successfully']);
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