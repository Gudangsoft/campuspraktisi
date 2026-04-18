<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyChooseUs;
use App\Models\WhyChooseUsFeature;
use Illuminate\Http\Request;

class WhyChooseUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = WhyChooseUs::with('features')->ordered()->get();
        return view('admin.why-choose-us.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.why-choose-us.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'icon_color' => 'required|string|max:7',
            'background_color' => 'required|string|max:7'
        ]);

        // Get the highest order and add 1
        $maxOrder = WhyChooseUs::max('order') ?? 0;
        $validated['order'] = $maxOrder + 1;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $item = WhyChooseUs::create($validated);

        return redirect()->route('admin.why-choose-us.index')
            ->with('success', 'Card berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WhyChooseUs $whyChooseUs)
    {
        return view('admin.why-choose-us.edit', compact('whyChooseUs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WhyChooseUs $whyChooseUs)
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'icon_color' => 'required|string|max:7',
            'background_color' => 'required|string|max:7'
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $whyChooseUs->update($validated);

        return redirect()->route('admin.why-choose-us.index')
            ->with('success', 'Card berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WhyChooseUs $whyChooseUs)
    {
        $whyChooseUs->delete();

        return redirect()->route('admin.why-choose-us.index')
            ->with('success', 'Card berhasil dihapus!');
    }

    /**
     * Update order of cards
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:why_choose_us,id',
            'items.*.order' => 'required|integer'
        ]);

        foreach ($request->items as $item) {
            WhyChooseUs::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui!']);
    }

    /**
     * Manage features for a card
     */
    public function features(WhyChooseUs $whyChooseUs)
    {
        $whyChooseUs->load('features');
        return view('admin.why-choose-us.features', compact('whyChooseUs'));
    }

    /**
     * Store a feature for a card
     */
    public function storeFeature(Request $request, WhyChooseUs $whyChooseUs)
    {
        $validated = $request->validate([
            'feature_text' => 'required|string',
            'icon' => 'nullable|string|max:255'
        ]);

        // Get the highest order and add 1
        $maxOrder = $whyChooseUs->features()->max('order') ?? 0;
        $validated['order'] = $maxOrder + 1;

        $whyChooseUs->features()->create($validated);

        return redirect()->route('admin.why-choose-us.features', $whyChooseUs->id)
            ->with('success', 'Fitur berhasil ditambahkan!');
    }

    /**
     * Update a feature
     */
    public function updateFeature(Request $request, WhyChooseUs $whyChooseUs, WhyChooseUsFeature $feature)
    {
        $validated = $request->validate([
            'feature_text' => 'required|string',
            'icon' => 'nullable|string|max:255'
        ]);

        $feature->update($validated);

        return redirect()->route('admin.why-choose-us.features', $whyChooseUs->id)
            ->with('success', 'Fitur berhasil diupdate!');
    }

    /**
     * Delete a feature
     */
    public function destroyFeature(WhyChooseUs $whyChooseUs, WhyChooseUsFeature $feature)
    {
        $feature->delete();

        return redirect()->route('admin.why-choose-us.features', $whyChooseUs->id)
            ->with('success', 'Fitur berhasil dihapus!');
    }

    /**
     * Reorder features
     */
    public function reorderFeatures(Request $request, WhyChooseUs $whyChooseUs)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:why_choose_us_features,id',
            'items.*.order' => 'required|integer'
        ]);

        foreach ($request->items as $item) {
            WhyChooseUsFeature::where('id', $item['id'])
                ->where('why_choose_us_id', $whyChooseUs->id)
                ->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan fitur berhasil diperbarui!']);
    }

    /**
     * Update section title and description settings
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'why_choose_us_title' => 'required|string|max:255',
            'why_choose_us_description' => 'required|string|max:255'
        ]);

        // Handle the enabled checkbox
        $validated['why_choose_us_enabled'] = $request->has('why_choose_us_enabled') ? '1' : '0';

        foreach ($validated as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => 'why_choose_us']
            );
        }

        return redirect()->route('admin.why-choose-us.index')
            ->with('success', 'Pengaturan section berhasil diperbarui!');
    }
}
