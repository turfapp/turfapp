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

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use JsonException;

/**
 * Class LogParameters
 *
 * Cast for encoding and decoding log parameters.
 *
 * @package App\Casts
 */
class LogParameters implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return array
     * @throws JsonException
     */
    public function get($model, $key, $value, $attributes): array
    {
        if (!isset($model->receiver) || !isset($model->actor)) {
            throw new InvalidArgumentException();
        }

        $json = is_resource($value) ? fread($value, 2048) : '{}';
        $value = (array)json_decode($json, true, 2, JSON_THROW_ON_ERROR);

        return $value + [
            'receiver_user_name' => $model->receiver->name,
            'actor_user_name' => $model->actor->name
        ];
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return string
     * @throws JsonException
     */
    public function set($model, $key, $value, $attributes): string
    {
        unset($value['receiver_user_name']);
        unset($value['actor_user_name']);

        return (string)json_encode($value, JSON_NUMERIC_CHECK | JSON_THROW_ON_ERROR, 2);
    }
}
