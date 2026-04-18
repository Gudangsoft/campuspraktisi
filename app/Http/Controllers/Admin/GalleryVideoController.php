<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryVideo;
use Illuminate\Http\Request;

class GalleryVideoController extends Controller
{
    public function index()
    {
        $videos = GalleryVideo::orderBy('order')->orderBy('created_at', 'desc')->get();
        return view('admin.gallery-videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.gallery-videos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_url' => 'required|url',
            'thumbnail' => 'nullable|image|max:2048',
            'category' => 'nullable|string|max:100',
            'video_date' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
            'order' => 'nullable|integer',
        ]);

        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('gallery/thumbnails', 'public');
        }

        GalleryVideo::create($data);

        return redirect()->route('admin.gallery-videos.index')->with('success', 'Video created');
    }

    public function edit($id)
    {
        $video = GalleryVideo::findOrFail($id);
        return view('admin.gallery-videos.edit', compact('video'));
    }

    public function update(Request $request, $id)
    {
        $video = GalleryVideo::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_url' => 'required|url',
            'thumbnail' => 'nullable|image|max:2048',
            'category' => 'nullable|string|max:100',
            'video_date' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
            'order' => 'nullable|integer',
        ]);

        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail && \Storage::disk('public')->exists($video->thumbnail)) {
                \Storage::disk('public')->delete($video->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('gallery/thumbnails', 'public');
        }

        $video->update($data);

        return redirect()->route('admin.gallery-videos.index')->with('success', 'Video updated');
    }

    public function destroy($id)
    {
        $video = GalleryVideo::findOrFail($id);

        if ($video->thumbnail && \Storage::disk('public')->exists($video->thumbnail)) {
            \Storage::disk('public')->delete($video->thumbnail);
        }

        $video->delete();

        return redirect()->route('admin.gallery-videos.index')->with('success', 'Video deleted');
    }
}
