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

namespace App\Events;

use App\Models\Group;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class GroupCreate
 *
 * This event is fired whenever a group is created.
 *
 * @package App\Events\Group
 */
class GroupCreate implements Event
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * @var User The user that created the group
     */
    private User $user;

    /**
     * @var Group The group that was created
     */
    private Group $group;

    /**
     * GroupJoin constructor.
     *
     * @param User $user The user that created the group
     * @param Group $group The group that was created
     */
    public function __construct(User $user, Group $group)
    {
        $this->user = $user;
        $this->group = $group;
    }

    /**
     * Get the user that created the group.
     *
     * @return User The user that created the group
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Get the group that was created.
     *
     * @return Group The group that was created
     */
    public function getGroup(): Group
    {
        return $this->group;
    }

    /**
     * @inheritDoc
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('turfapp');
    }
}
