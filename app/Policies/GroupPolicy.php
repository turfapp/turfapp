<?php

/*
 * TurfApp - An alternative for paper tally lists.
 * Copyright (C) 2021  Marijn van Wezel
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class GroupPolicy
 *
 * This policy governs the Group model.
 *
 * @see Group
 * @package App\Policies
 */
class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the group.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function view(User $user, Group $group): bool
    {
        return $group->has($user);
    }

    /**
     * Determine whether the user can update a user's balance in the group.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function updateBalance(User $user, Group $group): bool
    {
        return $group->has($user);
    }

    /**
     * Determine whether the user can reset another user's balance in the group.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function resetBalance(User $user, Group $group): bool
    {
        return $group->has($user) && $group->get($user)->member_is_admin;
    }

    /**
     * Determine whether the user can invite another user in the group.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function inviteUser(User $user, Group $group): bool
    {
        return $group->has($user);
    }

    /**
     * Determine whether the user can demote another user in the group.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function demoteUser(User $user, Group $group): bool
    {
        return $group->has($user) && $group->get($user)->member_is_admin;
    }

    /**
     * Determine whether the user can kick another user in the group.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function kickUser(User $user, Group $group): bool
    {
        return $group->has($user) && $group->get($user)->member_is_admin;
    }

    /**
     * Determine whether the user can promote another user in the group.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function promoteUser(User $user, Group $group): bool
    {
        return $group->has($user) && $group->get($user)->member_is_admin;
    }

    /**
     * Determine whether the user can reset the invite link of the group.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function resetInviteLink(User $user, Group $group): bool
    {
        return $group->has($user) && $group->get($user)->member_is_admin;
    }

    /**
     * Determine whether the user can update the settings of the group.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function updateSettings(User $user, Group $group): bool
    {
        return $group->has($user) && $group->get($user)->member_is_admin;
    }

    /**
     * Determine whether the user can update the stocktaking data of the group.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function updateStocktakingData(User $user, Group $group): bool
    {
        return $group->has($user);
    }

    /**
     * Determines whether the user can join the group.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function joinGroup(User $user, Group $group): bool
    {
        return true;
    }
}
