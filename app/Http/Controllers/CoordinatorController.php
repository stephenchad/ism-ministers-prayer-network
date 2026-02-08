<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoordinatorController extends Controller
{
    public function index()
    {
        $coordinators = \App\Models\Coordinator::where('is_active', true)->orderBy('sort_order')->get();
        return view('front.coordinators', compact('coordinators'));
    }
}