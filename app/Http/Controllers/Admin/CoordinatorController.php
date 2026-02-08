<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Coordinator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CoordinatorController extends Controller
{
    public function index()
    {
        $coordinators = Coordinator::orderBy('sort_order')->get();
        return view('admin.coordinators.index', compact('coordinators'));
    }

    public function create()
    {
        return view('admin.coordinators.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'availability' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/coordinators'), $imageName);
            $data['image'] = 'uploads/coordinators/' . $imageName;
        }

        Coordinator::create($data);

        return redirect()->route('admin.coordinators')->with('success', 'Coordinator created successfully');
    }

    public function edit($id)
    {
        $coordinator = Coordinator::findOrFail($id);
        return view('admin.coordinators.edit', compact('coordinator'));
    }

    public function update(Request $request, $id)
    {
        $coordinator = Coordinator::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'availability' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            if ($coordinator->image && File::exists(public_path($coordinator->image))) {
                File::delete(public_path($coordinator->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/coordinators'), $imageName);
            $data['image'] = 'uploads/coordinators/' . $imageName;
        }

        $coordinator->update($data);

        return redirect()->route('admin.coordinators')->with('success', 'Coordinator updated successfully');
    }

    public function destroy(Request $request)
    {
        $coordinator = Coordinator::findOrFail($request->id);
        
        if ($coordinator->image && File::exists(public_path($coordinator->image))) {
            File::delete(public_path($coordinator->image));
        }
        
        $coordinator->delete();

        return response()->json(['success' => true, 'message' => 'Coordinator deleted successfully']);
    }
}