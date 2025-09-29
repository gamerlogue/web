<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web([
            HandleInertiaRequests::class,
            LocaleMiddleware::class,
        ]);

        $middleware->trustProxies(at: [
            '10.0.0.0/8'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
//        $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
//            if (! app()->environment(['local', 'testing']) && in_array($response->getStatusCode(), [500, 503, 404, 403], true)) {
//                return Inertia::render('ErrorPage', ['status' => $response->getStatusCode()])
//                    ->toResponse($request)
//                    ->setStatusCode($response->getStatusCode());
//            }
//
//            if ($response->getStatusCode() === 419) {
//                return back()->with([
//                    'status' => __('The page expired, please try again.'),
//                ]);
//            }
//
//            return $response;
//        });
    })
    ->create();
