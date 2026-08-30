<?php

declare(strict_types=1);

use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web([
            HandleInertiaRequests::class,
            LocaleMiddleware::class,
        ]);

        /*
         * `localhost` is in the list on purpose: the base image's HEALTHCHECK calls
         * http://localhost:${CADDY_HTTP_PORT}${HEALTHCHECK_PATH}. Caddy answers that path itself
         * today, but pointing HEALTHCHECK_PATH at Laravel's /up would otherwise turn every
         * healthcheck into a 403 and restart-loop the container.
         */
        $middleware->trustHosts(at: static fn (): array => array_filter([
            parse_url((string) config('app.url'), PHP_URL_HOST),
            'localhost',
        ]), subdomains: true);

        $middleware->trustProxies(
            at: [
                '10.0.0.0/8',
                '172.16.0.0/12'
            ],
            headers: Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
