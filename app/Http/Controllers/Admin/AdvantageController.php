<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advantage;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdvantageController extends Controller
{
    public function index()
    {
        $advantages = Advantage::ordered()->get();
        return view('admin.advantages.index', compact('advantages'));
    }

    public function create()
    {
        return view('admin.advantages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'required|string|max:100',
            'icon_color' => 'required|string|max:20',
        ]);

        $validated['order'] = Advantage::max('order') + 1;
        $validated['is_active'] = $request->has('is_active');

        Advantage::create($validated);

        return redirect()->route('admin.advantages.index')
            ->with('success', 'Keunggulan berhasil ditambahkan');
    }

    public function edit(Advantage $advantage)
    {
        return view('admin.advantages.edit', compact('advantage'));
    }

    public function update(Request $request, Advantage $advantage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'required|string|max:100',
            'icon_color' => 'required|string|max:20',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $advantage->update($validated);

        return redirect()->route('admin.advantages.index')
            ->with('success', 'Keunggulan berhasil diupdate');
    }

    public function destroy(Advantage $advantage)
    {
        $advantage->delete();

        return redirect()->route('admin.advantages.index')
            ->with('success', 'Keunggulan berhasil dihapus');
    }

    public function reorder(Request $request)
    {
        $items = $request->input('items', []);

        foreach ($items as $item) {
            Advantage::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan berhasil diupdate']);
    }

    public function updateSettings(Request $request)
    {
        $settings = [
            'advantages_section_enabled' => $request->has('advantages_section_enabled') ? '1' : '0',
            'advantages_title' => $request->input('advantages_title', 'Keunggulan Kami'),
            'advantages_subtitle' => $request->input('advantages_subtitle', ''),
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => 'advantages']
            );
        }

        return redirect()->route('admin.advantages.index')
            ->with('success', 'Pengaturan section berhasil diupdate');
    }
}
