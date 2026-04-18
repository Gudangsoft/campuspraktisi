<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Exclude settings that have their own dedicated menu
        $settings = \App\Models\Setting::whereNotIn('group', ['theme', 'advantages', 'why_choose_us', 'testimonials', 'partners'])
                                       ->orderBy('group')
                                       ->get();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $setting = \App\Models\Setting::findOrFail($id);
        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $setting = \App\Models\Setting::findOrFail($id);

        // Handle image upload untuk logo dan favicon
        if ($setting->type === 'image' && $request->hasFile('value')) {
            $validated = $request->validate([
                'value' => 'nullable|image|max:2048',
            ]);

            // Delete old image if exists
            if ($setting->value && \Storage::disk('public')->exists($setting->value)) {
                \Storage::disk('public')->delete($setting->value);
            }

            // Upload new image
            $path = $request->file('value')->store('uploads', 'public');
            $setting->update(['value' => $path]);
        } else {
            // Custom validation for WhatsApp number
            if ($setting->key === 'whatsapp_number') {
                $data = $request->validate([
                    'value' => [
                        'nullable',
                        'string',
                        'regex:/^[0-9]+$/', // Only numbers
                        'min:10',
                        'max:15'
                    ],
                ], [
                    'value.regex' => 'Nomor WhatsApp hanya boleh berisi angka tanpa spasi atau karakter khusus',
                    'value.min' => 'Nomor WhatsApp minimal 10 digit',
                    'value.max' => 'Nomor WhatsApp maksimal 15 digit',
                ]);
            } else {
                $data = $request->validate([
                    'value' => 'nullable|string',
                ]);
            }

            // Handle checkbox toggle settings (if checkbox unchecked, value will be null)
            if (in_array($setting->key, ['whatsapp_float_enabled'])) {
                $setting->update(['value' => $request->has('value') ? '1' : '0']);
            } else {
                $setting->update(['value' => $data['value'] ?? '']);
            }
        }

        return redirect()->route('admin.settings.index')->with('success','Setting updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
