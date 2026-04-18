<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = \App\Models\News::with('category','user')->orderBy('created_at','desc')->paginate(15);
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\NewsCategory::active()->get();
        return view('admin.news.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:news_categories,id',
            'title' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:news,slug',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
        ]);

        $data['user_id'] = auth()->id() ?? 1;
        $data['is_featured'] = $request->has('is_featured') ? true : false;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        \App\Models\News::create($data);

        return redirect()->route('admin.news.index')->with('success','News created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = \App\Models\News::findOrFail($id);
        $categories = \App\Models\NewsCategory::active()->get();
        return view('admin.news.edit', compact('item','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = \App\Models\News::findOrFail($id);

        $data = $request->validate([
            'category_id' => 'required|exists:news_categories,id',
            'title' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:news,slug,'.$id,
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
        ]);

        $data['is_featured'] = $request->has('is_featured') ? true : false;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        $item->update($data);

        return redirect()->route('admin.news.index')->with('success','News updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = \App\Models\News::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.news.index')->with('success','News deleted');
    }

    /**
     * Bulk delete news
     */
    public function bulkDelete(\Illuminate\Http\Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return redirect()->route('admin.news.index')->with('error', 'Tidak ada berita yang dipilih');
        }

        $count = \App\Models\News::whereIn('id', $ids)->count();
        \App\Models\News::whereIn('id', $ids)->delete();

        return redirect()->route('admin.news.index')->with('success', "$count berita berhasil dihapus");
    }
}
