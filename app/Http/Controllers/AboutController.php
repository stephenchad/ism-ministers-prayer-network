<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coordinator;
use App\Models\SiteStat;
use App\Models\PageSection;
use App\Models\PageContent;

class AboutController extends Controller
{
    public function index() {
        $coordinators = Coordinator::where('is_active', true)
                                 ->orderBy('sort_order')
                                 ->take(3)
                                 ->get();
        
        // Fetch dynamic stats for about page
        $aboutStats = SiteStat::getForPage('about');
        
        // Fetch dynamic sections
        $featuresSection = PageSection::getByKeyAndPage('about_features', 'about');
        
        // Fetch page content for about page
        $pageContents = PageContent::getForPage('about');
        
        return view('front.about', compact('coordinators', 'aboutStats', 'featuresSection', 'pageContents'));
    }
}
