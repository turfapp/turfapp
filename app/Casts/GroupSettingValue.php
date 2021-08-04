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

namespace App\Casts;

use App\Models\GroupSetting;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Class GroupSettingValue
 *
 * Cast for encoding and decoding group settings.
 *
 * @package App\Casts
 */
class GroupSettingValue implements CastsAttributes
{
    /** @var array The type of each setting */
    private const TYPES = [
        'price_per_tally' => 'float'
    ];

    /**
     * Cast the given value.
     *
     * @param GroupSetting $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return mixed
     */
    public function get($model, $key, $value, $attributes): mixed
    {
        if (!is_resource($value)) {
            return $value;
        }

        if (!isset($model->group_setting_name)) {
            throw new InvalidArgumentException();
        }

        $setting_name = $model->group_setting_name;
        $type = self::TYPES[$setting_name] ?? 'string';
        $value = fread($value, 1024);

        return match ($type) {
            'float' => floatval($value),
            'integer', 'int' => intval($value),
            default => (string)$value
        };
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return mixed
     */
    public function set($model, $key, $value, $attributes): mixed
    {
        return $value;
    }
}
