<?php

declare(strict_types=1);

namespace App\Providers;

use ApiPlatform\JsonApi\Serializer\CollectionNormalizer;
use ApiPlatform\JsonApi\Serializer\ErrorNormalizer;
use ApiPlatform\JsonApi\Serializer\ItemDenormalizer;
use App\Models\Comment;
use App\Models\GameList;
use App\Models\LibraryEntry;
use App\Models\ListItem;
use App\Models\User;
use App\Serializer\CollectionMetaNormalizer;
use App\Serializer\DomainErrorNormalizer;
use App\Serializer\JsonApiResourceTypeDenormalizer;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Aliases for polymorphic columns. Not for users: their existing morphs (Sanctum tokens
        // first) store the class name, and an alias would orphan them.
        Relation::morphMap([
            'library_entry' => LibraryEntry::class,
            'list' => GameList::class,
            'list_item' => ListItem::class,
            'comment' => Comment::class,
        ]);

        RateLimiter::for('igdb', function (Request $request) {
            $limit = (int) config('services.igdb_proxy.rate_limit', 30);

            return [
                Limit::perMinute($limit)->by($request->user()?->getAuthIdentifier() ?? $request->ip()),
            ];
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

        $this->app->extend(ItemDenormalizer::class, fn (ItemDenormalizer $service) => new JsonApiResourceTypeDenormalizer($service));
        $this->app->extend(ErrorNormalizer::class, fn (ErrorNormalizer $service) => new DomainErrorNormalizer($service));
        $this->app->extend(CollectionNormalizer::class, fn (CollectionNormalizer $service) => new CollectionMetaNormalizer($service));

        LogViewer::auth(static fn ($request): bool => Gate::forUser($request->user())->allows('admin'));
    }
}
