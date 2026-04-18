<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from session, URL parameter, or default
        $locale = $request->get('lang') 
                  ?? Session::get('locale') 
                  ?? config('app.locale');
        
        // Validate locale is in available locales
        $availableLocales = array_keys(config('app.available_locales', ['id' => [], 'en' => []]));
        
        if (!in_array($locale, $availableLocales)) {
            $locale = config('app.locale');
        }
        
        // Set application locale
        App::setLocale($locale);
        Session::put('locale', $locale);
        
        return $next($request);
    }
}
