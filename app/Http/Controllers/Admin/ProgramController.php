<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.programs.list', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:200',
            'description' => 'required|min:10',
            'details' => 'required|min:20',
            'schedule' => 'required',
            'location' => 'required',
            'icon' => 'required',
            'color' => 'required'
        ]);

        if ($validator->passes()) {
            $data = $request->all();
            
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('programs', 'public');
            }
            
            Program::create($data);
            return redirect()->route('admin.programs')->with('success', 'Program created successfully.');
        }

        return redirect()->back()->withErrors($validator)->withInput();
    }

    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:200',
            'description' => 'required|min:10',
            'details' => 'required|min:20',
            'schedule' => 'required',
            'location' => 'required',
            'icon' => 'required',
            'color' => 'required'
        ]);

        if ($validator->passes()) {
            $program = Program::findOrFail($id);
            $data = $request->all();
            
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('programs', 'public');
            }
            
            $program->update($data);
            session()->flash('success', 'Program updated successfully.');
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false, 'errors' => $validator->errors()]);
    }

    public function destroy(Request $request)
    {
        $program = Program::find($request->id);
        if (!$program) {
            return response()->json(['status' => false]);
        }
        $program->delete();
        session()->flash('success', 'Program deleted successfully');
        return response()->json(['status' => true]);
    }
}
