<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::ordered()->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string'
        ]);

        // Upload logo
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        // Get max order
        $maxOrder = Partner::max('order') ?? 0;
        $validated['order'] = $maxOrder + 1;
        $validated['is_active'] = $request->has('is_active');

        Partner::create($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Mitra berhasil ditambahkan!');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string'
        ]);

        // Upload logo if new file
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $partner->update($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Mitra berhasil diperbarui!');
    }

    public function destroy(Partner $partner)
    {
        // Delete logo
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Mitra berhasil dihapus!');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'required|integer'
        ]);

        foreach ($request->orders as $id => $order) {
            Partner::where('id', $id)->update(['order' => $order]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui']);
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'partners_title' => 'required|string|max:255',
            'partners_subtitle' => 'nullable|string|max:255'
        ]);

        $validated['partners_section_enabled'] = $request->has('partners_section_enabled') ? '1' : '0';

        foreach ($validated as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => 'partners']
            );
        }

        return redirect()->route('admin.partners.index')
            ->with('success', 'Pengaturan section berhasil diperbarui!');
    }
}
