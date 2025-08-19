<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $fallback = config('app.locale', 'bg');
        $allowed  = config('app.locales', ['bg', 'en']);

        $locale = session('locale')
            ?? $request->cookie('locale')
            ?? ($request->user()->locale ?? null)
            ?? $fallback;

        if (!in_array($locale, $allowed, true)) {
            $locale = $fallback;
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
