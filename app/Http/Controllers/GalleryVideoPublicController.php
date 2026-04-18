<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryVideo;

class GalleryVideoPublicController extends Controller
{
    public function index()
    {
        $videos = GalleryVideo::where('is_active', true)
                             ->orderBy('order')
                             ->paginate(12);
        
        return view('frontend.gallery-video', compact('videos'));
    }
}
