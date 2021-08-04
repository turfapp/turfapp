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

namespace App\Events\Balance;

use App\Events\Event;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;

/**
 * Class BalanceUpdate
 *
 * This is the base class for any event that is fired when a member's balance is updated.
 *
 * @package App\Events\Balance
 */
abstract class BalanceUpdate implements Event
{
    /**
     * @var Membership
     */
    private Membership $membership;

    /**
     * @var int
     */
    private int $previous;

    /**
     * @var User
     */
    private User $actor;

    /**
     * Create a new event instance.
     *
     * @param Membership $membership
     * @param User $actor
     * @param int $previous
     */
    public function __construct(Membership $membership, User $actor, int $previous)
    {
        $this->membership = $membership;
        $this->previous = $previous;
        $this->actor = $actor;
    }

    /**
     * Returns the membership for which the balance was set.
     *
     * @return Membership
     */
    public function getMembership(): Membership
    {
        return $this->membership;
    }

    /**
     * Returns the previous balance of this member.
     *
     * @return int
     */
    public function getPrevious(): int
    {
        return $this->previous;
    }

    /**
     * Returns the current balance of this member.
     *
     * @return int
     */
    public function getCurrent(): int
    {
        return $this->membership->turf_amount;
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
