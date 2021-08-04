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

use App\Models\Membership;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class MembershipDemote
 *
 * This event is fired whenever someone demotes a member.
 *
 * @package App\Events\Balance
 */
class MembershipDemote implements Event
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * @var Membership
     */
    private Membership $membership;

    /**
     * @var User
     */
    private User $actor;

    /**
     * Create a new event instance.
     *
     * @param Membership $membership
     * @param User $actor
     */
    public function __construct(Membership $membership, User $actor)
    {
        $this->membership = $membership;
        $this->actor = $actor;
    }

    /**
     * Returns the membership that was demoted.
     *
     * @return Membership
     */
    public function getMembership(): Membership
    {
        return $this->membership;
    }

    /**
     * Returns the user who performed the update.
     *
     * @return User
     */
    public function getActor(): User
    {
        return $this->actor;
    }

    /**
     * @inheritDoc
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('turfapp');
    }
}
