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

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * @method static where(string $property, mixed $a, mixed $b = null)
 * @property int id The ID of this model (integer, auto-increment)
 * @property string group_name The unique group name as displayed in the request URL (char 32)
 * @property string group_display_name The display name of the group (string)
 * @property Collection memberships A Collection of Membership models for each member in this group
 * @property Collection users A Collection of User models for each user in this group
 * @property Collection turfLogs A Collection of TurfLog models for each log item associated with this group
 * @property Collection settings A Collection of GroupSetting models belonging to this group
 * @property GroupJoinCode|null groupJoinCode The GroupJoinCode model associated with this group
 * @property StocktakingData|null stocktakingData The StocktakingData model associated with this group
 */
class Group extends Model
{
    use HasFactory;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'group_name';
    }

    /**
     * Get the members of this group.
     *
     * @return HasMany
     */
    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    /**
     * Get the users in this group.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'memberships')
            ->using(Membership::class);
    }

    /**
     * Get the group join code for this group.
     *
     * @return HasOne
     */
    public function groupJoinCode(): HasOne
    {
        return $this->hasOne(GroupJoinCode::class);
    }

    /**
     * Get the logs for this group.
     *
     * @return HasMany
     */
    public function turfLogs(): HasMany
    {
        return $this->hasMany(TurfLog::class);
    }

    /**
     * Get the settings for this group.
     *
     * @return HasMany
     */
    public function settings(): HasMany
    {
        return $this->hasMany(GroupSetting::class);
    }

    /**
     * Get the stocktaking data for this group.
     *
     * @return HasOne
     */
    public function stocktakingData(): HasOne
    {
        return $this->hasOne(StocktakingData::class);
    }

    /**
     * Returns true if and only if the given user is a member of this group.
     *
     * @param User $user
     * @return bool
     */
    public function has(User $user): bool
    {
        return $this->memberships()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Returns the membership for the given user if it exists.
     *
     * @param User $user
     * @return Membership
     * @throws ModelNotFoundException If the user is not in this group
     */
    public function get(User $user): Membership
    {
        $membership = $this->memberships()
            ->where('user_id', $user->id)
            ->firstOrFail();

        if (!($membership instanceof Membership)) {
            throw new ModelNotFoundException();
        }

        return $membership;
    }
}
