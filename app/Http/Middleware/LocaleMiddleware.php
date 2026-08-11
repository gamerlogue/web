<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use LaravelLang\Locales\Data\LocaleData;
use LaravelLang\Locales\Facades\Locales;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cached as a plain array: a serialized Collection blows up on unserialize in workers
        // that boot before the framework classes are loaded.
        /** @var list<string> $availableLocales */
        $availableLocales = cache()->remember(
            'available_locales:v3',
            now()->addDay(),
            static fn (): array => Locales::available()
                ->map(static fn (LocaleData $locale): string => $locale->locale->value)
                ->all(),
        );

        $locale = $request->session()->get('locale', $request->getPreferredLanguage($availableLocales));

        if (! is_string($locale) || ! Locales::isAvailable($locale)) {
            $locale = config('app.locale');
        }

        app()->setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}
