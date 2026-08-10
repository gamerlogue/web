<?php

declare(strict_types=1);

namespace App\Providers;

use ApiPlatform\JsonApi\Serializer\ErrorNormalizer;
use ApiPlatform\JsonApi\Serializer\ItemNormalizer;
use ApiPlatform\Metadata\IriConverterInterface;
use App\Models\User;
use App\Serializer\JsonApiPlainIdNormalizer;
use App\Serializer\JsonApiStringStatusErrorNormalizer;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('igdb', function (Request $request) {
            $limit = (int) config('services.igdb_proxy.rate_limit', 30);

            return [
                Limit::perMinute($limit)->by($request->user()?->getAuthIdentifier() ?? $request->ip()),
            ];
        });

        Authenticate::redirectUsing(static function (Request $request) {
            return route('oidc.login');
        });

        /** Single source of truth for the admin check shared by Telescope, Horizon and the log viewer. */
        Gate::define('admin', static function (?User $user): bool {
            $adminEmail = config('app.admin_email');

            return is_string($adminEmail) && $adminEmail !== '' && $user?->email === $adminEmail;
        });

        Gate::define('viewLogViewer', static fn (?User $user): bool => app()->isLocal() || Gate::forUser($user)->allows('admin'));

        $this->app->extend(
            ItemNormalizer::class,
            fn ($service, $app) => new JsonApiPlainIdNormalizer($service, $app->make(IriConverterInterface::class)),
        );
        $this->app->extend(ErrorNormalizer::class, fn ($service, $app) => new JsonApiStringStatusErrorNormalizer($service));

        LogViewer::auth(static fn ($request): bool => Gate::forUser($request->user())->allows('admin'));
    }
}
