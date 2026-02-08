<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('status', true)
                   ->orderBy('created_at', 'desc')
                   ->paginate(12);
        
        return view('front.news.index', compact('news'));
    }

    public function show($slug)
    {
        $article = News::where('slug', $slug)
                      ->where('status', true)
                      ->firstOrFail();
        
        $related = News::where('status', true)
                      ->where('id', '!=', $article->id)
                      ->where('type', $article->type)
                      ->latest()
                      ->take(3)
                      ->get();
        
        return view('front.news.show', compact('article', 'related'));
    }
}
