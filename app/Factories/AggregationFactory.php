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

namespace App\Factories;

use App\Models\Membership;
use App\Models\TurfAggregation;

/**
 * Class AggregationFactory
 *
 * This class is responsible for creating TurfAggregation models.
 *
 * @package App\Factories
 */
class AggregationFactory implements Factory
{
    /**
     * @var Membership The membership that should be used for the aggregation
     */
    private Membership $membership;

    /**
     * @var int The difference (in balance) that should be used for the aggregation
     */
    private int $difference;

    /**
     * Set the membership to use.
     *
     * @param Membership $membership
     * @return $this
     */
    public function withMembership(Membership $membership): self
    {
        $this->membership = $membership;

        return $this;
    }

    /**
     * Set the difference to use.
     *
     * @param int $difference
     * @return $this
     */
    public function withDifference(int $difference): self
    {
        $this->difference = $difference;

        return $this;
    }

    /**
     * Create a new TurfAggregation model.
     *
     * @return TurfAggregation
     */
    public function create(): TurfAggregation
    {
        $object = new TurfAggregation();
        $object->user_id = $this->membership->user_id;
        $object->group_id = $this->membership->group_id;
        $object->amount = $this->difference;

        return $object;
    }
}
