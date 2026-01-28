<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class LanguageManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // if (session()->has('locale') && Schema::hasTable('settings')) {
        //     App::setLocale(session()->get('locale'));
        // }

        // Retrieve the locale from the cookie, session, or fallback to the default language setting
        $locale = Cookie::get('locale', session('locale', settings('language') ?? config('app.locale')));

        // If the cookie exists but the session has a locale, remove the session locale
        // This handles cases where the cookie might have been rejected or is out of sync
        if (Cookie::get('locale') && session()->has('locale')) {
            Session::forget('locale');
        }

        // Set the application locale based on the resolved locale value
        App::setLocale($locale);

        // Proceed with the next middleware or request handling
        return $next($request);
    }
}
