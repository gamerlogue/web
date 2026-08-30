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
         * the App Link that replaces the private-use scheme above. Empty means the route 404s.
         *
         * One entry per application, because debug and release are separate packages and each
         * needs its own statement — a single statement with both fingerprints would not verify
         * either. Declared as `package:FINGERPRINT[:FINGERPRINT...]`, semicolon separated, with
         * fingerprints as uppercase colon-separated SHA-256 of the signing certificate.
         *
         * @var array<int, array{package: string, fingerprints: list<string>}>
         */
        'android_apps' => array_values(array_filter(array_map(
            static function (string $app): ?array {
                [$package, $fingerprints] = array_pad(explode('=', trim($app), 2), 2, null);

                if (! is_string($package) || $package === '' || ! is_string($fingerprints) || $fingerprints === '') {
                    return null;
                }

                return [
                    'package' => $package,
                    'fingerprints' => array_values(array_filter(array_map('trim', explode(',', $fingerprints)))),
                ];
            },
            array_filter(explode(';', (string) env('NATIVE_AUTH_ANDROID_APPS'))),
        )))
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
