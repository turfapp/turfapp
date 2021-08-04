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

use App\Models\Membership;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class BalanceDecrement
 *
 * This event is fired whenever a member's balance is decremented.
 *
 * @package App\Events
 */
class BalanceDecrement extends BalanceUpdate
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * BalanceDecrement constructor.
     *
     * @param Membership $membership
     * @param User $user
     */
    public function __construct(Membership $membership, User $user)
    {
        // x = y - 1 => y = x + 1
        $previous = $membership->turf_amount + 1;
        parent::__construct($membership, $user, $previous);
    }
}
