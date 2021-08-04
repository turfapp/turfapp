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

namespace App\Listeners;

use App\Events\Balance\BalanceUpdate;
use App\Factories\AggregationFactory;

/**
 * Class CreateBalanceAggregation
 *
 * @package App\Listeners
 */
class CreateBalanceAggregation implements Listener
{
    private AggregationFactory $factory;

    /**
     * CreateBalanceAggregation constructor.
     *
     * @param AggregationFactory $factory
     */
    public function __construct(AggregationFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Handle the event.
     *
     * @param BalanceUpdate $event
     * @return void
     */
    public function handle($event): void
    {
        $this->factory
            ->withMembership($event->getMembership())
            ->withDifference($event->getCurrent() - $event->getPrevious())
            ->create()
            ->save();
    }
}
