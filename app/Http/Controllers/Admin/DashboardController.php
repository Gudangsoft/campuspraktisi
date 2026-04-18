<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_news' => \App\Models\News::count(),
            'published_news' => \App\Models\News::where('status', 'published')->count(),
            'draft_news' => \App\Models\News::where('status', 'draft')->count(),
            'total_categories' => \App\Models\NewsCategory::count(),
            'total_menus' => \App\Models\Menu::count(),
            'total_views' => \App\Models\News::sum('views'),
        ];

        $latest_news = \App\Models\News::with('category', 'user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $popular_news = \App\Models\News::published()
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latest_news', 'popular_news'));
    }
}
