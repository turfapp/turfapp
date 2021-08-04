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

use App\Http\Helpers\Awards\Award;
use App\Http\Helpers\Awards\Awards;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $property, mixed $a, mixed $b = null)
 * @property int id The ID of this model (integer, auto-increment)
 * @property mixed member_join_timestamp The timestamp of when this member joined the group (timestamp)
 * @property bool member_is_admin Whether this member is an administrator in the group (boolean)
 * @property int turf_amount The amount of tally's this user has in this group (integer)
 * @property int group_id The ID of the Group model to which this member (foreign key)
 * @property int user_id The ID of the User model of this member (foreign key)
 * @property Group group The group to which this member belongs
 * @property User user The user model of this member
 * @property Award[] awards The awards this member has
 */
class Membership extends Model
{
    use HasFactory;

    /**
     * Get the group this membership belongs to.
     *
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the user this membership belongs to.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the awards this membership has.
     *
     * @return array
     */
    public function getAwardsAttribute(): array
    {
        // TODO: Make awards injectable through lookup class
        return Awards::forMembership($this);
    }
}
