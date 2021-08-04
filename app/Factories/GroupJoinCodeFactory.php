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

namespace App\Factories;

use App\Models\Group;
use App\Models\GroupJoinCode;
use Illuminate\Support\Str;

/**
 * Class GroupJoinCode
 *
 * This class is responsible for creating GroupJoinCode models.
 *
 * @package App\Factories
 */
class GroupJoinCodeFactory implements Factory
{
    private Group $group;

    /**
     * Set the group for which to generate a new join code model.
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
     * Creates the GroupJoinCode model.
     *
     * @return GroupJoinCode
     */
    public function create(): GroupJoinCode
    {
        $object = new GroupJoinCode();

        $object->group_join_code = $this->generateGroupJoinCode();
        $object->group_id = $this->group->id;

        return $object;
    }

    /**
     * Generates a group join code.
     *
     * @return string
     */
    private function generateGroupJoinCode(): string
    {
        $part_a = Str::random(14);
        $part_b = Str::random(8);
        $part_c = Str::random(8);

        return implode('-', [$part_a, $part_b, $part_c]);
    }
}
