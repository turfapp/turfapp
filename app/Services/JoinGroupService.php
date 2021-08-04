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

use App\Events\GroupJoin;
use App\Factories\MembershipFactory;
use App\Models\Group;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class JoinGroupService
 *
 * The join group service provides methods for joining a group. It also handles event broadcasting.
 *
 * @package App\Services
 */
class JoinGroupService
{
    private Group $group;
    private User $user;
    private MembershipFactory $membershipFactory;
    private bool $admin = false;

    /**
     * JoinGroupService constructor.
     *
     * @param MembershipFactory $membershipFactory
     */
    public function __construct(MembershipFactory $membershipFactory)
    {
        $this->membershipFactory = $membershipFactory;
    }

    /**
     * Sets the user that wants to join.
     *
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Set the group that the user wants to join.
     *
     * @param Group $group
     * @return $this
     */
    public function setGroup(Group $group): self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Set whether the user should be an admin.
     *
     * @param bool $admin
     * @return $this
     */
    public function setAdmin(bool $admin = true): self
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Join the group.
     *
     * @return Membership The created Membership model
     */
    public function join(): Membership
    {
        return DB::transaction(function () {
            $membership = $this->membershipFactory
                ->forGroup($this->group)
                ->forUser($this->user)
                ->isAdmin($this->admin)
                ->create();
            $membership->save();

            GroupJoin::dispatch($membership);

            return $membership;
        });
    }
}
