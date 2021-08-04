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

namespace App\Repositories;

use App\Models\Group;
use App\Models\GroupSetting;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class GroupSettingRepository
 *
 * @package App\Repositories
 */
class GroupSettingRepository implements Repository
{
    /** @var array The default value of each setting */
    private const DEFAULTS = [
        'price_per_tally' => 0.75
    ];

    /**
     * @inheritDoc
     */
    public function getFromId(int $id): Builder
    {
        return GroupSetting::where('id', $id);
    }

    /**
     * Returns the value of the given setting name for the given group, or the setting's default
     * value when the setting is not set for that group. Returns null when no default value
     * exists.
     *
     * @param Group $group
     * @param string $setting_name
     * @return mixed
     */
    public function getSettingOrDefault(string $setting_name, Group $group): mixed
    {
        $default = fn() => self::DEFAULTS[$setting_name] ?? null;
        $value = GroupSetting::where('group_setting_name', $setting_name)
            ->where('group_id', $group->id)
            ->firstOr($default);

        return $value instanceof GroupSetting ? $value->group_setting_value : $value;
    }
}
