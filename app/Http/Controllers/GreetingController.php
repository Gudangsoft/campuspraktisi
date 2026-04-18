<?php

namespace App\Http\Controllers;

use App\Models\Greeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GreetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $greetings = Greeting::orderBy('order')->paginate(10);
        return view('admin.greetings.index', compact('greetings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.greetings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'person_name' => 'nullable|string|max:255',
            'person_title' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('greetings', 'public');
            $validated['image'] = $path;
        }

        // Set default values
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        Greeting::create($validated);

        return redirect()->route('admin.greetings.index')
            ->with('success', 'Sambutan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Greeting $greeting)
    {
        return view('admin.greetings.show', compact('greeting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Greeting $greeting)
    {
        return view('admin.greetings.edit', compact('greeting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Greeting $greeting)
    {
        $validated = $request->validate([
            'section_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'person_name' => 'nullable|string|max:255',
            'person_title' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($greeting->image && Storage::disk('public')->exists($greeting->image)) {
                Storage::disk('public')->delete($greeting->image);
            }
            
            $image = $request->file('image');
            $path = $image->store('greetings', 'public');
            $validated['image'] = $path;
        }

        // Set default values
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        $greeting->update($validated);

        return redirect()->route('admin.greetings.index')
            ->with('success', 'Sambutan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Greeting $greeting)
    {
        // Delete image
        if ($greeting->image && Storage::disk('public')->exists($greeting->image)) {
            Storage::disk('public')->delete($greeting->image);
        }

        $greeting->delete();

        return redirect()->route('admin.greetings.index')
            ->with('success', 'Sambutan berhasil dihapus.');
    }
}
