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

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $property, mixed $a, mixed $b = null)
 * @property int id The ID of this model (integer, auto-increment)
 * @property int total_num_tallies The total number of tallies made in this group (integer)
 * @property int total_difference The total difference between the expected amount of tallies and
 * the actual amount (integer)
 * @property int current_inventory The number of items currently in stock (integer)
 * @property int group_id The ID of the Group model for which this is the stocktaking data (foreign key)
 * @property Group group The group to which for which this is the stocktaking data
 * @property float|int|null discrepancy The current discrepancy
 */
class StocktakingData extends Model
{
    use HasFactory;

    /**
     * @inheritDoc
     */
    public $timestamps = false;

    /**
     * Get the group this data belongs to.
     *
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Returns the percentage of tallies that were correctly entered into the system.
     *
     * @return float|int|null The discrepancy percentage, or null if the total number of
     * tallies is zero (division by zero)
     */
    public function getDiscrepancyAttribute(): float|int|null
    {
        // The total number of tallies are the registered tallies plus the tallies that weren't registered
        $total_tallied = $this->total_num_tallies + $this->total_difference;

        if ($total_tallied === 0) {
            return null;
        }

        return ($this->total_num_tallies / $total_tallied) * 100;
    }
}
