<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    // 'sanctum/token' is the native authorize endpoint: the browser navigates to it rather than
    // fetching it, so it needs no CORS entry.
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // Explicit origins, because a wildcard is illegal once credentials are allowed: the browser
    // rejects `Access-Control-Allow-Origin: *` on a request carrying cookies.
    'allowed_origins' => explode(',', (string) env('CORS_ALLOWED_ORIGINS'))
            |> (fn ($x) => array_map('trim', $x))
            |> array_filter(...)
            |> array_values(...),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // The web client authenticates with the session cookie, which is only sent cross-origin when
    // this is true.
    'supports_credentials' => true,

];
