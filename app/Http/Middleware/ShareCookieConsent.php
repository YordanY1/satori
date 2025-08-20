<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShareCookieConsent
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'cookie_prefs_v1';
        $json = $request->cookies->get($key);

        $consent = ['analytics' => false, 'marketing' => false, 'exists' => false];

        if ($json) {
            try {
                $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
                $consent = [
                    'analytics' => (bool) ($data['analytics'] ?? false),
                    'marketing' => (bool) ($data['marketing'] ?? false),
                    'exists'    => true,
                ];
            } catch (\Throwable $e) {
                // ignore bad cookie
            }
        }

        // Share with all views
        view()->share('cookieConsent', $consent);

        return $next($request);
    }
}
