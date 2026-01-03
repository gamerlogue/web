<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $locale = $request->session()->get('locale', $request->getPreferredLanguage($available_locales));
        if (is_string($locale)) {
            app()->setLocale($locale);
            Carbon::setLocale($locale);
        }
        return $next($request);
    }
}
