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

use App\Casts\LogParameters;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $property, mixed $a, mixed $b = null)
 * @property int id The ID of this model (integer, auto-increment)
 * @property string turf_log_type The type of this log item (enum)
 * @property array turf_log_params Any additional parameters this log item may have (binary)
 * @property int group_id The group to which this log item belongs (foreign id)
 * @property int actor_user_id The actor of this log item (foreign id)
 * @property int receiver_user_id The receiver/target of this log item (foreign id)
 * @property mixed created_at The timestamp at which this model was inserted into the database (timestamp)
 * @property User actor The actor user of this log item
 * @property User receiver The receiver/target user of this log item
 * @property Group group The group to which this log item belongs
 * @property string iconClass The CSS class of the icon associated with this log item
 * @property string messageKey The key of the message for this log item
 */
class TurfLog extends Model
{
    use HasFactory;

    private const ICON_CLASSES = [
        'increment' => 'fas fa-plus increment',
        'decrement' => 'fas fa-minus decrement',
        'useradd' => 'fas fa-user-plus',
        'userleave' => 'fas fa-user-minus',
        'userdel' => 'fas fa-user-times',
        'updatesettings' => 'fas fa-wrench',
        'creategroup' => 'fas fa-glass-cheers',
        'userreset' => 'fas fa-undo',
        'userpromote' => 'fas fa-arrow-up',
        'userdemote' => 'fas fa-arrow-down',
        'stockedit' => 'fas fa-dolly-flatbed',
        'stockeditdry' => 'fas fa-dolly-flatbed'
    ];

    private const MESSAGE_KEYS = [
        'increment' => ':receiver_user_name received a tally from :actor_user_name',
        'decrement' => ':actor_user_name removed a tally from :receiver_user_name',
        'useradd' => ':receiver_user_name joined the group',
        'userleave' => ':receiver_user_name left the group',
        'userdel' => ':actor_user_name removed :receiver_user_name from the group',
        'updatesettings' => ':actor_user_name updated the group settings',
        'creategroup' => ':actor_user_name created this group',
        'userreset' => ":actor_user_name set the outstanding tally's of :receiver_user_name from :previous_amount to 0",
        'userpromote' => ':actor_user_name promoted :receiver_user_name to administrator',
        'userdemote' => ':actor_user_name demoted :receiver_user_name to member',
        'stockedit' => ':actor_user_name added :num_items_bought to the stock',
        'stockeditdry' => ':actor_user_name updated the stock',
    ];

    protected $casts = [
        'turf_log_params' => LogParameters::class,
    ];

    /**
     * Get the actor (user which performed the action) for this log item.
     *
     * @return BelongsTo
     */
    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_user_id');
    }

    /**
     * Get the receiver (user on which the action was performed) for this log item.
     *
     * @return BelongsTo
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_user_id');
    }

    /**
     * Get the group associated with this log item.
     *
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Returns the icon class for the icon belonging to this log
     * item. Can be used by a frontend to display an icon with this
     * log.
     *
     * @return string
     * @throws Exception
     */
    public function getIconClassAttribute(): string
    {
        return self::ICON_CLASSES[$this->turf_log_type] ??
            throw new Exception('Invalid log type');
    }

    /**
     * Returns the message key for displaying this log item to
     * the user in a frontend.
     *
     * @return string
     * @throws Exception
     */
    public function getMessageKeyAttribute(): string
    {
        return self::MESSAGE_KEYS[$this->turf_log_type] ??
            throw new Exception('Invalid log type');
    }
}
