<?php

namespace App\Providers;

use ApiPlatform\JsonApi\Serializer\ErrorNormalizer;
use ApiPlatform\JsonApi\Serializer\ItemNormalizer;
use ApiPlatform\Laravel\Eloquent\Filter\FilterInterface;
use App\Filter\CurrentUserFilter;
use App\Models\User;
use App\Serializer\JsonApiPlainIdNormalizer;
use App\Serializer\JsonApiStringStatusErrorNormalizer;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::macro(
            'inertiaModal',
            function (string $route, string $component, string $baseRoute, array|Arrayable $props = []) {
                return $this->get($route, static function () use ($component, $baseRoute, $props) {
                    return inertia()->modal($component, $props)
                        ->baseRoute($baseRoute)
                        ->refreshBackdrop(request()->header('Referer') !== route($baseRoute));
                });
            }
        );

        // Rate limiter per proxy IGDB (per IP)
        RateLimiter::for('igdb', function (Request $request) {
            $limit = (int) config('services.igdb.rate_limit', 30);

            return [
                Limit::perMinute($limit)->by($request->ip()),
            ];
        });

        Authenticate::redirectUsing(static function (Request $request) {
            return route('oidc.login');
        });

        Gate::define('viewLogViewer', static fn (?User $user) => app()->isLocal() || $user?->email === config('app.admin_email'));

        // Estendiamo il normalizzatore di item JSON:API
        $this->app->extend(ItemNormalizer::class, fn ($service, $app) => new JsonApiPlainIdNormalizer($service));
        $this->app->extend(ErrorNormalizer::class, fn ($service, $app) => new JsonApiStringStatusErrorNormalizer($service));

        $this->app->tag(CurrentUserFilter::class, FilterInterface::class);
    }
}
