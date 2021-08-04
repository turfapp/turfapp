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

namespace App\Factories;

use App\Models\Group;
use App\Models\Membership;
use App\Models\User;

/**
 * Class MembershipFactory
 *
 * This class is responsible for creating Membership models.
 *
 * @package App\Factories
 */
class MembershipFactory implements Factory
{
    /**
     * @var Group The group this membership will belong to
     */
    private Group $group;

    /**
     * @var User The user this membership will belong to
     */
    private User $user;

    /**
     * @var bool Whether the membership has admin status
     */
    private bool $admin;

    /**
     * Set the group this membership will belong to.
     *
     * @param Group $group
     * @return $this
     */
    public function forGroup(Group $group): self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Set the user this membership will belong to.
     *
     * @param User $user
     * @return $this
     */
    public function forUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Set whether the membership has admin status.
     *
     * @param bool $admin
     * @return $this
     */
    public function isAdmin(bool $admin = true): self
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function create(): Membership
    {
        $object = new Membership();

        $object->member_join_timestamp = now();
        $object->member_is_admin = $this->admin;
        $object->group_id = $this->group->id;
        $object->user_id = $this->user->id;
        $object->turf_amount = 0;

        return $object;
    }
}
