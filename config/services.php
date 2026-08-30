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

        /*
         * Digital Asset Links, served at /.well-known/assetlinks.json so that Android can verify
         * the App Link that replaces the private-use scheme above. Unset means the route 404s.
         * Fingerprints are the SHA-256 of the signing certificates, uppercase and colon-separated;
         * both the debug and the release certificate belong here while both are in use.
         */
        'android_package' => env('NATIVE_AUTH_ANDROID_PACKAGE'),
        'android_fingerprints' => array_values(array_filter(array_map('trim', explode(',', (string) env('NATIVE_AUTH_ANDROID_FINGERPRINTS'))))),
    ],

    'igdb_proxy' => [
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
