<?php

/*
 * TurfApp - TurfApp - An alternative for paper tally lists.
 *  Copyright (C) 2021  Marijn van Wezel
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

namespace App\Services;

use App\Events\MembershipDemote;
use App\Events\MembershipPromote;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class GroupAdminService
 *
 * The group admin service provides methods for promoting and demoting users in a group.
 *
 * @package App\Services
 */
class GroupAdminService
{
    private Membership $membership;
    private User $actor;

    /**
     * Sets the membership for which to update the admin status.
     *
     * @param Membership $membership
     * @return $this
     */
    public function setMembership(Membership $membership): self
    {
        $this->membership = $membership;

        return $this;
    }

    /**
     * Set the user who performs the update.
     *
     * @param User $actor
     * @return $this
     */
    public function setActor(User $actor): self
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * Promotes the specified member to admin. This function does nothing if the user is
     * already an admin.
     */
    public function promote(): void
    {
        DB::transaction(function () {
            if ($this->membership->member_is_admin) {
                // The member is already an admin
                return;
            }

            $this->membership->member_is_admin = true;
            $this->membership->save();

            MembershipPromote::dispatch($this->membership, $this->actor);
        });
    }

    /**
     * Demotes the specified member to user. This function does nothing if the user is
     * already a user.
     */
    public function demote(): void
    {
        DB::transaction(function () {
            if (!$this->membership->member_is_admin) {
                // The member is already an admin
                return;
            }

            $this->membership->member_is_admin = false;
            $this->membership->save();

            MembershipDemote::dispatch($this->membership, $this->actor);
        });
    }
}
