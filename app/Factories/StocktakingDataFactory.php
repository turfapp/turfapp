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

use App\Models\Group;
use App\Models\StocktakingData;

/**
 * Class StocktakingDataFactory
 *
 * This class is responsible for creating StocktakingData models.
 *
 * @package App\Factories
 */
class StocktakingDataFactory implements Factory
{
    private int $totalNumTallies;
    private int $totalDifference;
    private int $currentInventory;
    private Group $group;

    /**
     * Set the total number of tallies for the model.
     *
     * @param int $totalNumTallies
     * @return $this
     */
    public function withTotalNumTallies(int $totalNumTallies): self
    {
        $this->totalNumTallies = $totalNumTallies;

        return $this;
    }

    /**
     * Set the total difference for the model.
     *
     * @param int $totalDifference
     * @return $this
     */
    public function withTotalDifference(int $totalDifference): self
    {
        $this->totalDifference = $totalDifference;

        return $this;
    }

    /**
     * Set the current inventory for the model.
     *
     * @param int $currentInventory
     * @return $this
     */
    public function withCurrentInventory(int $currentInventory): self
    {
        $this->currentInventory = $currentInventory;

        return $this;
    }

    /**
     * Set the group to which this model should belong.
     *
     * @param Group $group
     * @return $this
     */
    public function forGroup(Group $group): self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function create(): StocktakingData
    {
        $object = new StocktakingData();

        $object->total_num_tallies = $this->totalNumTallies;
        $object->total_difference = $this->totalDifference;
        $object->current_inventory = $this->currentInventory;
        $object->group_id = $this->group->id;

        return $object;
    }
}
