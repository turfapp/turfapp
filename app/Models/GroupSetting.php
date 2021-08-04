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

namespace App\Models;

use App\Casts\GroupSettingValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $property, mixed $a, mixed $b = null)
 * @property int id The ID of this model (integer, auto-increment)
 * @property string group_setting_name The name of the setting (string)
 * @property resource group_setting_value The value of the setting (binary)
 * @property int group_id The ID of the Group model to which this setting belongs (foreign key)
 * @property Group group The group to which this setting belongs
 */
class GroupSetting extends Model
{
    use HasFactory;

    public $casts = [
        'group_setting_value' => GroupSettingValue::class
    ];

    /**
     * Get the group associated with this log item.
     *
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
