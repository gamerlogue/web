<?php

declare(strict_types=1);

namespace App\Providers;

use ApiPlatform\JsonApi\Serializer\ErrorNormalizer;
use ApiPlatform\JsonApi\Serializer\ItemNormalizer;
use ApiPlatform\Metadata\IriConverterInterface;
use ApiPlatform\Metadata\Resource\Factory\ResourceMetadataCollectionFactoryInterface;
use ApiPlatform\Metadata\Resource\Factory\ResourceNameCollectionFactoryInterface;
use App\Models\User;
use App\Notifications\RefreshTokenReuseAlert;
use App\Serializer\JsonApiPlainIdNormalizer;
use App\Serializer\JsonApiStringStatusErrorNormalizer;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;
use Reiarseni\SanctumRefreshToken\Events\RefreshTokenReuseDetected;
use Reiarseni\SanctumRefreshToken\Events\TokenFamilyRevoked;

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

        /**
         * A replayed refresh token is a security incident, not a failed request: the family is gone
         * by the time this fires, and the only record of why is this line. Kept synchronous — a
         * queued listener has no request to read the client address from.
         */
        Event::listen(static function (RefreshTokenReuseDetected $event): void {
            $userId = (string) $event->tokenable->getKey();
            $ip = request()->ip();

            Log::warning('Refresh token reuse detected', [
                'user_id' => $userId,
                'family_uuid' => $event->familyUuid,
                'ip' => $ip,
                'replayed_generation' => $event->replayedGeneration,
                'current_generation' => $event->currentGeneration,
                'seconds_since_rotation' => $event->secondsSinceRotation,
            ]);

            $adminEmail = config('app.admin_email');

            if (! is_string($adminEmail) || $adminEmail === '') {
                return;
            }

            // A compromised token gets replayed in a loop, not once. add() returns false while the
            // key lives, so the first detection alerts and the storm behind it only logs.
            if (! Cache::add("refresh-token-reuse-alert:$userId", true, now()->addMinutes(5))) {
                return;
            }

            Notification::route('mail', $adminEmail)
                ->notify(new RefreshTokenReuseAlert($userId, $event->familyUuid, $ip));
        });

        Event::listen(static function (TokenFamilyRevoked $event): void {
            Log::info('Token family revoked', [
                'user_id' => $event->tokenable->getKey(),
                'family_uuid' => $event->familyUuid,
                'reason' => $event->reason->value,
                'ip' => request()->ip(),
            ]);
        });

        Authenticate::redirectUsing(static function (Request $request) {
            return route('oidc.login');
        });

        /** Single source of truth for the admin check shared by Telescope, Pulse, Horizon and the log viewer. */
        Gate::define('admin', static function (?User $user): bool {
            $adminEmail = config('app.admin_email');

            return is_string($adminEmail) && $adminEmail !== '' && $user?->email === $adminEmail;
        });

        Gate::define('viewLogViewer', static fn (?User $user): bool => app()->isLocal() || Gate::forUser($user)->allows('admin'));

        Gate::define('viewPulse', static fn (?User $user): bool => Gate::forUser($user)->allows('admin'));

        $this->app->extend(
            ItemNormalizer::class,
            fn ($service, $app) => new JsonApiPlainIdNormalizer(
                $service,
                $app->make(IriConverterInterface::class),
                $app->make(ResourceNameCollectionFactoryInterface::class),
                $app->make(ResourceMetadataCollectionFactoryInterface::class),
            ),
        );
        $this->app->extend(ErrorNormalizer::class, fn ($service, $app) => new JsonApiStringStatusErrorNormalizer($service));

        LogViewer::auth(static fn ($request): bool => Gate::forUser($request->user())->allows('admin'));
    }
}
