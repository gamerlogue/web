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
        $package = config('services.native_auth.android_package');
        $fingerprints = config('services.native_auth.android_fingerprints');

        abort_if(! is_string($package) || $package === '' || $fingerprints === [], 404);

        return response()->json([
            [
                'relation' => ['delegate_permission/common.handle_all_urls'],
                'target' => [
                    'namespace' => 'android_app',
                    'package_name' => $package,
                    'sha256_cert_fingerprints' => $fingerprints,
                ],
            ],
        ]);
    }
}
