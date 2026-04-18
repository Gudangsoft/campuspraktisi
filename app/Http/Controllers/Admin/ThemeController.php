<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Display theme settings.
     */
    public function index()
    {
        $themeSettings = Setting::where('group', 'theme')->get()->keyBy('key');
        return view('admin.themes.index', compact('themeSettings'));
    }

    /**
     * Update theme settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'theme_primary_color' => 'required|string|max:7',
            'theme_secondary_color' => 'required|string|max:7',
            'theme_success_color' => 'required|string|max:7',
            'theme_danger_color' => 'required|string|max:7',
            'theme_warning_color' => 'required|string|max:7',
            'theme_info_color' => 'required|string|max:7',
            'theme_topbar_bg_color' => 'required|string|max:7',
            'theme_topbar_text_color' => 'required|string|max:7',
            'theme_header_bg_color' => 'required|string|max:7',
            'theme_header_text_color' => 'required|string|max:7',
            'theme_footer_bg_color' => 'required|string|max:7',
            'theme_footer_text_color' => 'required|string|max:7',
            'theme_button_bg_color' => 'required|string|max:7',
            'theme_button_text_color' => 'required|string|max:7',
            'theme_link_color' => 'required|string|max:7',
            'theme_link_hover_color' => 'required|string|max:7',
        ]);

        foreach ($validated as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        return redirect()->route('admin.theme.index')
            ->with('success', 'Theme settings updated successfully!');
    }

    /**
     * Reset theme to default colors.
     */
    public function reset()
    {
        $defaults = [
            'theme_primary_color' => '#1e90ff',
            'theme_secondary_color' => '#6c757d',
            'theme_success_color' => '#198754',
            'theme_danger_color' => '#dc3545',
            'theme_warning_color' => '#ffc107',
            'theme_info_color' => '#0dcaf0',
            'theme_topbar_bg_color' => '#1a1a2e',
            'theme_topbar_text_color' => '#e0e0e0',
            'theme_header_bg_color' => '#ffffff',
            'theme_header_text_color' => '#212529',
            'theme_footer_bg_color' => '#003366',
            'theme_footer_text_color' => '#ffffff',
            'theme_button_bg_color' => '#1e90ff',
            'theme_button_text_color' => '#ffffff',
            'theme_link_color' => '#1e90ff',
            'theme_link_hover_color' => '#0066cc',
        ];

        foreach ($defaults as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        return redirect()->route('admin.theme.index')
            ->with('success', 'Theme reset to default colors successfully!');
    }
}
