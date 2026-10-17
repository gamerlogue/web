<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Follow;
use App\Models\GameList;
use App\Models\LibraryEntry;
use App\Models\Notification;
use App\Models\Reaction;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Reiarseni\SanctumRefreshToken\SanctumRefreshToken;

/**
 * Deleting the account (a Google Play requirement) and exporting its data. Plain JSON.
 */
class AccountController
{
    /**
     * Deletes the user and everything of theirs for good. Content goes through its models, so that
     * the replies, likes, notifications and activities hanging off it go too; the rest follows the
     * foreign keys (sessions and OIDC mappings included). Reports about the user stay, for
     * moderation.
     */
    public function destroy(Request $request): Response
    {
        $user = $this->user($request);

        DB::transaction(static function () use ($user): void {
            foreach ([LibraryEntry::class, GameList::class, Comment::class, Reaction::class] as $model) {
                $model::where('user_id', $user->id)->get()->each(static fn ($record) => $record->delete());
            }
            Follow::where('followable_type', $user->getMorphClass())->where('followable_id', $user->id)->get()->each->delete();
            Notification::where('data->actor->id', $user->id)->delete();
            $user->notifications()->delete();
            $user->tokens()->delete();
            SanctumRefreshToken::query()->where('tokenable_type', $user->getMorphClass())->where('tokenable_id', $user->id)->delete();
            $user->forceDelete();
        });

        if ($request->hasSession()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
        }

        return response()->noContent();
    }

    /**
     * Everything the user created, as one downloadable JSON document.
     */
    public function export(Request $request): JsonResponse
    {
        $user = $this->user($request);

        return response()->json([
            'exported_at' => now()->toIso8601String(),
            'profile' => $user->makeVisible(['id', 'email'])->makeHidden(['nickname_key'])->only([
                'id', 'email', 'email_verified_at', 'nickname', 'first_name', 'last_name', 'picture', 'bio',
                'banner_game_id', 'banner_image_id', 'platforms_ids', 'visibility', 'created_at',
            ]),
            'library' => LibraryEntry::where('user_id', $user->id)->get()->makeVisible('id'),
            'lists' => GameList::where('user_id', $user->id)->with('items')->get()->makeVisible('id'),
            'comments' => Comment::where('user_id', $user->id)->get(['id', 'commentable_type', 'commentable_id', 'comment', 'spoiler', 'created_at', 'updated_at'])->makeVisible('id'),
            'reactions' => Reaction::where('user_id', $user->id)->get(['reactable_type', 'reactable_id', 'type', 'created_at']),
            'following' => $user->followings()->pluck('followable_id'),
            'followers' => $user->followers()->pluck('users.id'),
            'blocked' => $user->blocks()->pluck('blocked_id'),
            'reports' => Report::where('user_id', $user->id)->get(['reportable_type', 'reportable_id', 'reason', 'note', 'created_at']),
        ], headers: ['Content-Disposition' => 'attachment; filename="gamerlogue-export.json"']);
    }

    private function user(Request $request): User
    {
        /** @var User $user */
        $user = $request->user();
        abort_unless($user->tokenCan('profile'), 403);

        return $user;
    }
}
