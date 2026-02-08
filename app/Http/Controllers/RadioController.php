<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Radio;
use App\Models\PageContent;

class RadioController extends Controller
{
    public function index()
    {
        $radios = Radio::with('schedules')->where('is_active', true)->orderBy('sort_order')->get();
        
        // Fetch page content for radio page
        $pageContents = PageContent::getForPage('radio');
        
        return view('front.radio', compact('radios', 'pageContents'));
    }
}
