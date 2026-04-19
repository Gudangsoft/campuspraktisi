<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = \App\Models\Slider::active()->orderBy('order')->get();
        $greetings = \App\Models\Greeting::active()->ordered()->get();
        $whyChooseUs = \App\Models\WhyChooseUs::with('features')->active()->ordered()->get();
        $featuredNews = \App\Models\News::with('tags')->published()->featured()->latest()->take(3)->get();
        $latestNews = \App\Models\News::with('tags')->published()->latest()->take(15)->get();
        $galleryPhotos = \App\Models\GalleryPhoto::where('is_active', true)->orderBy('order')->take(6)->get();
        $galleryVideos = \App\Models\GalleryVideo::where('is_active', true)->orderBy('order')->take(4)->get();
        $agendas = \App\Models\Agenda::active()->upcoming()->take(3)->get();
        $announcements = \App\Models\Announcement::active()->latest()->take(5)->get();
        $menus = \App\Models\Menu::active()->parent()->orderBy('order')->get();
        $prodiUnggulan = \App\Models\ProdiUnggulan::latest()->get();
        
        return view('frontend.home', compact('sliders', 'greetings', 'whyChooseUs', 'featuredNews', 'latestNews', 'galleryPhotos', 'galleryVideos', 'agendas', 'announcements', 'menus', 'prodiUnggulan'));
    
    public function pimpinan()
    {
        return view('frontend.pimpinan');
    }
}
