<?php

namespace App\Providers;

use Illuminate\Contracts\Support\Arrayable;
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
    }
}
