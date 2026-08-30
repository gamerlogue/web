<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * Serves the Digital Asset Links statement that lets Android verify the App Link, so the client
 * can drop the private-use scheme any app is free to register.
 */
class AssetLinksController
{
    public function __invoke(): JsonResponse
    {
        $statements = 'services.native_auth.android_apps'
                |> config(...)
                |> (fn ($x) => array_map(static fn (array $app): array => ['relation' => ['delegate_permission/common.handle_all_urls'], 'target' => ['namespace' => 'android_app', 'package_name' => $app['package'], 'sha256_cert_fingerprints' => $app['fingerprints']]], $x))
                |> array_values(...);

        abort_if($statements === [], 404);

        return response()->json($statements);
    }
}
