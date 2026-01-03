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
            // We can't use the standard App::setLocale($locale) here because it would fire the LocaleUpdated event,
            // which would result in a crash due to Carbon trying to load the Laravel config service.
            app('translator')->setLocale($locale);
            Carbon::setLocale($locale);
            config(['app.locale' => $locale]);
        }
        return $next($request);
    }
}
