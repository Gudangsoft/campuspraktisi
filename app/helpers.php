<?php

if (!function_exists('setting')) {
    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        return \App\Models\Setting::get($key, $default);
    }
}

if (!function_exists('current_locale')) {
    /**
     * Get current application locale
     *
     * @return string
     */
    function current_locale(): string
    {
        return app()->getLocale();
    }
}

if (!function_exists('available_locales')) {
    /**
     * Get all available locales
     *
     * @return array
     */
    function available_locales(): array
    {
        return config('app.available_locales', []);
    }
}

if (!function_exists('locale_name')) {
    /**
     * Get locale name
     *
     * @param string|null $locale
     * @return string
     */
    function locale_name(?string $locale = null): string
    {
        $locale = $locale ?: current_locale();
        $locales = available_locales();
        
        return $locales[$locale]['name'] ?? $locale;
    }
}

if (!function_exists('locale_flag')) {
    /**
     * Get locale flag emoji
     *
     * @param string|null $locale
     * @return string
     */
    function locale_flag(?string $locale = null): string
    {
        $locale = $locale ?: current_locale();
        $locales = available_locales();
        
        return $locales[$locale]['flag'] ?? '🌐';
    }
}
