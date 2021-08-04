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
use App\Models\GroupSetting;

/**
 * Class GroupSettingFactory
 *
 * This class is responsible for creating GroupSetting models.
 *
 * @package App\Factories
 */
class GroupSettingFactory implements Factory
{
    private Group $group;
    private string $name;
    private mixed $value;

    /**
     * Set the group for which to generate a setting model.
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
     * Set the name of the setting.
     *
     * @param string $name
     * @return $this
     */
    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of the setting.
     *
     * @param mixed $value
     * @return $this
     */
    public function withValue(mixed $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Creates the GroupSetting model.
     *
     * @return GroupSetting
     */
    public function create(): GroupSetting
    {
        $object = new GroupSetting();

        $object->group_id = $this->group->id;
        $object->group_setting_name = $this->name;
        $object->group_setting_value = $this->value;

        return $object;
    }
}
