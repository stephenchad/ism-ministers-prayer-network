<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Group;
use App\Models\PrayerRequest;
use App\Models\Testimony;
use App\Models\News;
use App\Models\WorshipMusic;
use App\Models\Stream;
use App\Models\StreamParticipant;
use App\Models\PageSlider;
use App\Models\SiteStat;
use App\Models\PageSection;
use App\Models\PageContent;
use App\Services\CommerceApiClient;
use App\Services\TestCommerceApiClient;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create commerce API client - uses test client when real API is unavailable
     */
    private function createCommerceApiClient(): CommerceApiClient|TestCommerceApiClient
    {
        try {
            // Try to create real commerce API client
            $client = new CommerceApiClient();
            
            // Test if the real API is accessible and has books
            $testResponse = $client->getBooks(['limit' => 1]);
            
            if (!$testResponse['success'] || empty($testResponse['data']['books'])) {
                Log::info('HomeController: Real commerce API not available or empty, using test client');
                return new TestCommerceApiClient();
            }
            
            return $client;
        } catch (\Exception $e) {
            Log::info('HomeController: Commerce API connection failed, using test client', [
                'error' => $e->getMessage()
            ]);
            return new TestCommerceApiClient();
        }
    }

    // This method will show the home page
    public function index()
    {
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->take(8)->get();

        $featuredGroups = Group::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->where('isFeatured', 1)->take(6)->get();

        $latestGroups = Group::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->take(6)->get();

        $programs = \App\Models\Program::where('status', 1)->take(6)->get();
        $news = News::where('status', 1)->orderBy('created_at', 'desc')->take(6)->get();
        $testimonies = Testimony::where('allow_publish', 1)->orderBy('created_at', 'desc')->take(6)->get();
        $prayerPoints = \App\Models\PrayerPoint::where('status', 'approved')->latest()->take(3)->get();
        $streams = Stream::where('is_active', true)->latest()->get();

        // Fetch books from commerce API (or test client)
        $commerceApi = $this->createCommerceApiClient();
        $booksResponse = $commerceApi->getBooks(['limit' => 6]);
        $allBooks = $booksResponse['success'] ? ($booksResponse['data']['books'] ?? []) : [];
        
        // Filter out book ID 1
        $books = collect($allBooks)->filter(function($book) {
            return ($book['id'] ?? 0) != 1;
        })->values()->all();
        
        $usingTestBooks = $commerceApi instanceof TestCommerceApiClient;

        // Fetch dynamic content from database
        $sliders = PageSlider::getForPage('home');
        $homeStats = SiteStat::getForPage('home');
        $howWeServeSection = PageSection::getByKey('how_we_serve');
        $callToActionSection = PageSection::getByKey('call_to_action');
        
        // Fetch page content for home page
        $pageContents = PageContent::getForPage('home');

        return view('front.home', [
            'categories' => $categories,
            'featuredGroups' => $featuredGroups,
            'latestGroups' => $latestGroups,
            'programs' => $programs,
            'news' => $news,
            'testimonies' => $testimonies,
            'prayerPoints' => $prayerPoints,
            'streams' => $streams,
            'books' => $books,
            'usingTestBooks' => $usingTestBooks,
            'sliders' => $sliders,
            'homeStats' => $homeStats,
            'howWeServeSection' => $howWeServeSection,
            'callToActionSection' => $callToActionSection,
            'pageContents' => $pageContents,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        if (empty($query)) {
            return redirect()->back()->with('error', 'Please enter a search term.');
        }

        // Search in groups
        $groups = Group::where('status', 1)
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', '%' . $query . '%')
                    ->orWhere('description', 'LIKE', '%' . $query . '%')
                    ->orWhere('city', 'LIKE', '%' . $query . '%')
                    ->orWhere('country', 'LIKE', '%' . $query . '%');
            })
            ->with('category')
            ->paginate(10, ['*'], 'groups');

        // Search in prayer requests
        $prayers = PrayerRequest::where('prayer_request', 'LIKE', '%' . $query . '%')
            ->orWhere('name', 'LIKE', '%' . $query . '%')
            ->paginate(10, ['*'], 'prayers');

        // Search in testimonies
        $testimonies = Testimony::where('allow_publish', 1)
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', '%' . $query . '%')
                    ->orWhere('testimony', 'LIKE', '%' . $query . '%')
                    ->orWhere('name', 'LIKE', '%' . $query . '%');
            })
            ->paginate(10, ['*'], 'testimonies');

        // Search in programs
        $programs = \App\Models\Program::where('status', 1)
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', '%' . $query . '%')
                    ->orWhere('description', 'LIKE', '%' . $query . '%');
            })
            ->paginate(10, ['*'], 'programs');

        // Search in news
        $news = News::where('status', 1)
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', '%' . $query . '%')
                    ->orWhere('content', 'LIKE', '%' . $query . '%');
            })
            ->paginate(10, ['*'], 'news');

        $totalResults = $groups->total() + $prayers->total() + $testimonies->total() + $programs->total() + $news->total();

        return view('front.search', compact('query', 'groups', 'prayers', 'testimonies', 'programs', 'news', 'totalResults'));
    }

    public function worshipMusic()
    {
        $streamingMusic = WorshipMusic::where('is_active', 1)
            ->where('music_type', 'streaming')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        $downloadMusic = WorshipMusic::where('is_active', 1)
            ->where('music_type', 'download')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('front.worship-music', compact('streamingMusic', 'downloadMusic'));
    }

    public function storeStreamParticipant(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'gender' => 'required|in:male,female,other',
            'participants_count' => 'required|integer|min:1',
        ]);

        StreamParticipant::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'gender' => $request->gender,
            'participants_count' => $request->participants_count,
            'stream_id' => $request->stream_id ?? null,
            'submitted_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Thank you for participating!']);
    }

    public function prayerRoom()
    {
        return view('front.prayer-room');
    }

}
