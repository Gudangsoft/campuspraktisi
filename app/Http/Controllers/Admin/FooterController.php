<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSection;
use App\Models\FooterLink;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    /**
     * Display a listing of footer sections.
     */
    public function index()
    {
        $sections = FooterSection::with('links')->ordered()->get();
        return view('admin.footer.index', compact('sections'));
    }

    /**
     * Show the form for creating a new section.
     */
    public function createSection()
    {
        return view('admin.footer.create-section');
    }

    /**
     * Store a newly created section.
     */
    public function storeSection(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        FooterSection::create($validated);

        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer section created successfully.');
    }

    /**
     * Show the form for editing a section.
     */
    public function editSection(FooterSection $section)
    {
        return view('admin.footer.edit-section', compact('section'));
    }

    /**
     * Update the specified section.
     */
    public function updateSection(Request $request, FooterSection $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $section->update($validated);

        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer section updated successfully.');
    }

    /**
     * Remove the specified section.
     */
    public function destroySection(FooterSection $section)
    {
        $section->delete();

        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer section deleted successfully.');
    }

    /**
     * Show the form for creating a new link.
     */
    public function createLink(FooterSection $section)
    {
        return view('admin.footer.create-link', compact('section'));
    }

    /**
     * Store a newly created link.
     */
    public function storeLink(Request $request, FooterSection $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $validated['footer_section_id'] = $section->id;
        $validated['open_new_tab'] = $request->has('open_new_tab');
        $validated['is_active'] = $request->has('is_active');

        FooterLink::create($validated);

        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer link created successfully.');
    }

    /**
     * Show the form for editing a link.
     */
    public function editLink(FooterLink $link)
    {
        return view('admin.footer.edit-link', compact('link'));
    }

    /**
     * Update the specified link.
     */
    public function updateLink(Request $request, FooterLink $link)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $validated['open_new_tab'] = $request->has('open_new_tab');
        $validated['is_active'] = $request->has('is_active');

        $link->update($validated);

        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer link updated successfully.');
    }

    /**
     * Remove the specified link.
     */
    public function destroyLink(FooterLink $link)
    {
        $link->delete();

        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer link deleted successfully.');
    }
}
