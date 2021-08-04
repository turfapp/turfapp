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

namespace App\Services;

use App\Events\Balance\BalanceDecrement;
use App\Events\Balance\BalanceIncrement;
use App\Events\Balance\BalanceReset;
use App\Events\Balance\BalanceSet;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class BalanceService
 *
 * The balance service provides methods for updating the balance (number of open tally's) for
 * the given membership. It also handles event broadcasting.
 *
 * @package App\Services
 */
class BalanceService
{
    private Membership $membership;
    private User $actor;

    /**
     * Sets the membership for which to update the balance.
     *
     * @param Membership $membership
     * @return $this
     */
    public function setMembership(Membership $membership): self
    {
        $this->membership = $membership;

        return $this;
    }

    /**
     * Set the user who performs the balance update (used for logging).
     *
     * @param User $actor
     * @return $this
     */
    public function setActor(User $actor): self
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * Increment the membership's balance by one.
     */
    public function increment(): void
    {
        DB::transaction(function () {
            $this->membership->turf_amount++;

            // Update the database
            $this->membership->save();

            // Dispatch the increment even
            BalanceIncrement::dispatch($this->membership, $this->actor);
        });
    }

    /**
     * Decrement the membership's balance by one.
     */
    public function decrement(): void
    {
        DB::transaction(function () {
            $this->membership->turf_amount--;

            // Update the database
            $this->membership->save();

            // Dispatch the decrement event
            BalanceDecrement::dispatch($this->membership, $this->actor);
        });
    }

    /**
     * Set the membership's balance to a specific value.
     *
     * @param int $value The value to set the membership's balance to
     */
    public function set(int $value): void
    {
        DB::transaction(function () use ($value) {
            $previous = $this->membership->turf_amount;
            $this->membership->turf_amount = $value;

            // Update the database
            $this->membership->save();

            // Dispatch the set event
            BalanceSet::dispatch($this->membership, $this->actor, $previous);
        });
    }

    /**
     * Reset the membership's balance to zero.
     */
    public function reset(): void
    {
        DB::transaction(function () {
            $previous = $this->membership->turf_amount;
            $this->membership->turf_amount = 0;

            // Update the database
            $this->membership->save();

            // Dispatch the reset event
            BalanceReset::dispatch($this->membership, $this->actor, $previous);
        });
    }
}
