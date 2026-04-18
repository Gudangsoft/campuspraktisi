<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryPhoto;

class GalleryPhotoPublicController extends Controller
{
    public function index()
    {
        $photos = GalleryPhoto::where('is_active', true)
                             ->orderBy('order')
                             ->paginate(12);
        
        return view('frontend.gallery-photo', compact('photos'));
    }
}
