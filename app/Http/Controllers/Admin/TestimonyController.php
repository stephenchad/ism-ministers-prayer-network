<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Testimony;
use Illuminate\Http\Request;

class TestimonyController extends Controller
{
    public function index()
    {
        $testimonies = Testimony::orderBy('created_at', 'desc')->get();
        return view('admin.testimonies.index', compact('testimonies'));
    }

    public function create()
    {
        return view('admin.testimonies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'location' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'testimony' => 'required|string'
        ]);

        Testimony::create($request->all());

        return redirect()->route('admin.testimonies')->with('success', 'Testimony created successfully');
    }

    public function edit($id)
    {
        $testimony = Testimony::findOrFail($id);
        return view('admin.testimonies.edit', compact('testimony'));
    }

    public function update(Request $request, $id)
    {
        $testimony = Testimony::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'location' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'testimony' => 'required|string'
        ]);

        $testimony->update($request->all());

        return redirect()->route('admin.testimonies')->with('success', 'Testimony updated successfully');
    }

    public function destroy(Request $request)
    {
        $testimony = Testimony::findOrFail($request->id);
        $testimony->delete();

        return response()->json(['success' => true, 'message' => 'Testimony deleted successfully']);
    }
}