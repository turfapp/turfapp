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

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static where(string $property, mixed $a, mixed $b = null)
 * @method static create(array $attributes)
 * @property int id The ID of this model (integer, auto-increment)
 * @property string name The name of this user (string)
 * @property string email The email address of this user (string)
 * @property mixed email_verified_at The timestamp of when this email was verified (timestamp)
 * @property string password The hashed and salted version of this user's password
 * @property string firstName The first name of this user
 * @property Collection memberships The memberships belonging to this user
 * @property Collection groups The groups this user is in
 * @property Collection actorTurfLogs The log items where this user is the "actor"
 * @property Collection receiverTurfLogs The log items where this user the "receiver"/"target"
 * @property Collection membershipsSorted The memberships belonging to this user sorted on "created_at" date
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var string[]
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's first name.
     *
     * @return string
     */
    public function getFirstNameAttribute(): string
    {
        return ucfirst(explode(' ', $this->name)[0]);
    }

    /**
     * Returns the user's memberships.
     *
     * @return HasMany
     */
    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    /**
     * Returns the turf groups this user is in.
     *
     * @return BelongsToMany
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'memberships')
            ->using(Membership::class);
    }

    /**
     * Return the logs where this user was the actor.
     *
     * @return HasMany
     */
    public function actorTurfLogs(): HasMany
    {
        return $this->hasMany(TurfLog::class, 'actor_user_id');
    }

    /**
     * Return the logs where this user was the receiver.
     *
     * @return HasMany
     */
    public function receiverTurfLogs(): HasMany
    {
        return $this->hasMany(TurfLog::class, 'receiver_user_id');
    }

    /**
     * Get the members of this user sorted by join date.
     *
     * @return Collection
     */
    public function getMembershipsSortedAttribute(): Collection
    {
        return $this->memberships->sortByDesc('created_at');
    }
}
