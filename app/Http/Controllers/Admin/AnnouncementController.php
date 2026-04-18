<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('published_date', 'desc')->orderBy('order')->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:255',
            'published_date' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'is_active' => 'boolean',
            'is_important' => 'boolean',
            'order' => 'integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_important'] = $request->has('is_important');

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('announcements', 'public');
        }

        Announcement::create($validated);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:255',
            'published_date' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'is_active' => 'boolean',
            'is_important' => 'boolean',
            'order' => 'integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_important'] = $request->has('is_important');

        if ($request->hasFile('file')) {
            // Delete old file
            if ($announcement->file) {
                Storage::disk('public')->delete($announcement->file);
            }
            $validated['file'] = $request->file('file')->store('announcements', 'public');
        }

        $announcement->update($validated);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diupdate.');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->file) {
            Storage::disk('public')->delete($announcement->file);
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function updateSettings(Request $request)
    {
        $enabled = $request->has('announcement_section_enabled') ? '1' : '0';
        
        \App\Models\Setting::updateOrCreate(
            ['key' => 'announcement_section_enabled'],
            ['value' => $enabled, 'group' => 'announcement']
        );

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengaturan section berhasil diperbarui!');
    }
}
