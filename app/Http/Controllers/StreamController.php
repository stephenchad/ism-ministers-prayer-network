<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stream;
use App\Models\PageContent;

class StreamController extends Controller
{
    public function index()
    {
        $streams = Stream::where('is_active', true)->latest()->get();
        
        // Fetch page content for stream page
        $pageContents = PageContent::getForPage('stream');
        
        return view('front.stream', compact('streams', 'pageContents'));
    }
}
