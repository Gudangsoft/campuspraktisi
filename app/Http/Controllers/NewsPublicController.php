<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsPublicController extends Controller
{
    public function index()
    {
        $news = \App\Models\News::published()->latest()->paginate(12);
        $categories = \App\Models\NewsCategory::active()->get();
        
        return view('frontend.news.index', compact('news', 'categories'));
    }

    public function show($slug)
    {
        $item = \App\Models\News::where('slug', $slug)->published()->firstOrFail();
        $item->increment('views');
        
        $related = \App\Models\News::published()
            ->where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->take(3)
            ->get();
        
        // Data untuk sidebar
        $latestNews = \App\Models\News::published()
            ->where('id', '!=', $item->id)
            ->latest()
            ->take(5)
            ->get();
            
        $popularNews = \App\Models\News::published()
            ->where('id', '!=', $item->id)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();
            
        $categories = \App\Models\NewsCategory::active()
            ->withCount(['news' => function($query) {
                $query->published();
            }])
            ->get();
        
        return view('frontend.news.show', compact('item', 'related', 'latestNews', 'popularNews', 'categories'));
    }

    public function category($slug)
    {
        $category = \App\Models\NewsCategory::where('slug', $slug)->firstOrFail();
        $news = \App\Models\News::published()
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);
        
        return view('frontend.news.category', compact('news', 'category'));
    }
}
