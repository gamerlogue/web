<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $available_locales = cache()->rememberForever(
            'available_locales',
            static fn () => array_map(
                static fn (string $path) => basename($path, '.json'),
                glob(lang_path('*.json'), GLOB_NOSORT)
            )
        );
        $locale = session('locale', $request->getPreferredLanguage($available_locales));
        if (is_string($locale)) {
            app()->setLocale($locale);
        }
        return $next($request);
    }
}
