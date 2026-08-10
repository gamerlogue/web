<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'native_auth' => [
        'redirect_uris' => array_values(array_filter(array_map('trim', explode(',', env('NATIVE_AUTH_REDIRECT_URIS', 'gamerlogue://auth/callback'))))),
    ],

    'igdb_proxy' => [
        'allowed_paths' => array_values(array_filter(array_map('trim', explode(',', env('IGDB_PROXY_ALLOWED_PATHS', 'games,events'))))),
        'rate_limit' => (int) env('IGDB_PROXY_RATE_LIMIT', 30),
        'event_cache_lifetime' => (int) env('IGDB_PROXY_EVENT_CACHE_LIFETIME', 5),
        'event_stale_lifetime' => (int) env('IGDB_PROXY_EVENT_STALE_LIFETIME', 10),
    ],

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
];
