<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrayerResource;
use App\Models\PageContent;
use App\Http\Controllers\Controller;

class PrayerRoomController extends Controller
{
      public function index()
      {
            $resources = PrayerResource::where('is_active', true)
                  ->where('resource_type', 'file')
                  ->orderBy('sort_order')
                  ->get();
            $videos = PrayerResource::where('is_active', true)
                  ->where('resource_type', 'video')
                  ->orderBy('sort_order')
                  ->get();
            $guides = PrayerResource::where('is_active', true)
                  ->where('resource_type', 'guide')
                  ->orderBy('sort_order')
                  ->get();
            
            // Fetch page content for prayer room page
            $pageContents = PageContent::getForPage('prayer-room');
            
            return view('front.prayer-room', compact('resources', 'videos', 'guides', 'pageContents'));
      }
}
