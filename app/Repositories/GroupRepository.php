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

namespace App\Repositories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class GroupRepository
 *
 * @package App\Repositories
 */
class GroupRepository implements Repository
{
    /**
     * Returns the group with the given ID.
     *
     * @param int $id
     * @return Builder
     */
    public function getFromId(int $id): Builder
    {
        return Group::where('id', $id);
    }

    /**
     * Returns the group model with the given group name.
     *
     * @param string $group_name
     * @return Builder
     */
    public function getFromGroupName(string $group_name): Builder
    {
        return Group::where('group_name', $group_name);
    }
}
