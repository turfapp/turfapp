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

use App\Events\GroupCreate;
use App\Factories\GroupFactory;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class CreateGroupService
 *
 * The group create service provides method for creating groups. It also handles event broadcasting.
 *
 * @package App\Services
 */
class CreateGroupService
{
    private string $displayName;
    private User $user;
    private GroupFactory $groupFactory;
    private JoinGroupService $joinGroupService;
    private GroupJoinCodeService $groupJoinCodeService;

    /**
     * CreateGroupService constructor.
     *
     * @param GroupFactory $groupFactory
     * @param JoinGroupService $joinGroupService
     * @param GroupJoinCodeService $groupJoinCodeService
     */
    public function __construct(
        GroupFactory $groupFactory,
        JoinGroupService $joinGroupService,
        GroupJoinCodeService $groupJoinCodeService
    ) {
        $this->groupFactory = $groupFactory;
        $this->joinGroupService = $joinGroupService;
        $this->groupJoinCodeService = $groupJoinCodeService;
    }

    /**
     * Sets the display name of the group the user wants to create.
     *
     * @param string $displayName
     * @return $this
     */
    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Sets the user that wants to create a group.
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
     * Creates the group with the set group name and adds the current user to it.
     *
     * @return Group The created Group model
     */
    public function create(): Group
    {
        return DB::transaction(function () {
            $group = $this->groupFactory
                ->withDisplayName($this->displayName)
                ->create();
            $group->save();

            $this->joinGroupService
                ->setGroup($group)
                ->setAdmin()
                ->setUser($this->user)
                ->join();

            $this->groupJoinCodeService
                ->setGroup($group)
                ->update();

            GroupCreate::dispatch($this->user, $group);

            return $group;
        });
    }
}
