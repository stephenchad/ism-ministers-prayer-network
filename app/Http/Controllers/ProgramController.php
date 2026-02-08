<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::where('status', 1)->get();
        return view('front.programs', compact('programs'));
    }

    public function show($slug)
    {
        $program = Program::where('slug', $slug)->where('status', 1)->firstOrFail();
        return view('front.program-detail', compact('program'));
    }
}
