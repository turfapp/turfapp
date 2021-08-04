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

use App\Factories\GroupJoinCodeFactory;
use App\Models\Group;
use App\Models\GroupJoinCode;
use Illuminate\Support\Facades\DB;

/**
 * Class GroupJoinCodeService
 *
 * The group join code service provides methods creating and updating group join codes.
 *
 * @package App\Services
 */
class GroupJoinCodeService
{
    private Group $group;
    private GroupJoinCodeFactory $groupJoinCodeFactory;

    /**
     * GroupJoinCodeService constructor.
     *
     * @param GroupJoinCodeFactory $groupJoinCodeFactory
     */
    public function __construct(GroupJoinCodeFactory $groupJoinCodeFactory)
    {
        $this->groupJoinCodeFactory = $groupJoinCodeFactory;
    }

    /**
     * Set the group for which to create or update the join code.
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
     * Updates the existing group join code, or creates the initial group join code
     * if it did not exist yet. This function returns the created GroupJoinCode model.
     *
     * @return GroupJoinCode The created model
     */
    public function update(): GroupJoinCode
    {
        return DB::transaction(function () {
            $group_join_code = $this->groupJoinCodeFactory
                ->forGroup($this->group)
                ->create();

            // Delete the previous group join code (if it exists)
            $this->group->groupJoinCode?->delete();
            $group_join_code->save();

            return $group_join_code;
        });
    }
}
