<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use LaravelLang\Locales\Data\LocaleData;
use LaravelLang\Locales\Facades\Locales;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $available_locales = cache()->rememberForever(
            'available_locales',
            static fn () =>
            /** @var Collection<LocaleData> $langs */
            Locales::available()->map(fn (LocaleData $lang) => $lang->locale->value)
        );
        $locale = $request->session()->get('locale', $request->getPreferredLanguage($available_locales));
        if (is_string($locale)) {
            app()->setLocale($locale);
            Carbon::setLocale($locale);
        }
        return $next($request);
    }
}
