<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;

class GalleryPhotoController extends Controller
{
    public function index()
    {
        $photos = GalleryPhoto::orderBy('order')->orderBy('created_at', 'desc')->get();
        return view('admin.gallery-photos.index', compact('photos'));
    }

    public function create()
    {
        return view('admin.gallery-photos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:5120',
            'category' => 'nullable|string|max:100',
            'photo_date' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
            'order' => 'nullable|integer',
        ]);

        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('gallery/photos', 'public');
        }

        GalleryPhoto::create($data);

        return redirect()->route('admin.gallery-photos.index')->with('success', 'Photo created');
    }

    public function edit($id)
    {
        $photo = GalleryPhoto::findOrFail($id);
        return view('admin.gallery-photos.edit', compact('photo'));
    }

    public function update(Request $request, $id)
    {
        $photo = GalleryPhoto::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'category' => 'nullable|string|max:100',
            'photo_date' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
            'order' => 'nullable|integer',
        ]);

        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($photo->image && \Storage::disk('public')->exists($photo->image)) {
                \Storage::disk('public')->delete($photo->image);
            }
            $data['image'] = $request->file('image')->store('gallery/photos', 'public');
        }

        $photo->update($data);

        return redirect()->route('admin.gallery-photos.index')->with('success', 'Photo updated');
    }

    public function destroy($id)
    {
        $photo = GalleryPhoto::findOrFail($id);

        if ($photo->image && \Storage::disk('public')->exists($photo->image)) {
            \Storage::disk('public')->delete($photo->image);
        }

        $photo->delete();

        return redirect()->route('admin.gallery-photos.index')->with('success', 'Photo deleted');
    }
}
