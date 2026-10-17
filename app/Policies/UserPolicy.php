<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Visibility;
use App\Models\User;

final class UserPolicy
{
    public function update(User $viewer, User $user): bool
    {
        return $viewer->is($user) && $viewer->tokenCan('profile');
    }

    /**
     * Account data only the owner sees, such as the email address.
     *
     * Both field checks run as API Platform property security, which also asks while deserializing
     * a write and passes no object then. Writes only ever reach the caller's own user, so that is
     * not a read to restrict.
     */
    public function viewPrivateFields(User $viewer, ?User $user = null): bool
    {
        return $user === null || $viewer->is($user);
    }

    /**
     * Everything beyond the public card (id, nickname, name, picture, visibility): profile fields,
     * library, statistics and the rest.
     */
    public function viewProfile(User $viewer, ?User $user = null): bool
    {
        return $user === null || $viewer->is($user) || $user->visibility === Visibility::Public;
    }
}
