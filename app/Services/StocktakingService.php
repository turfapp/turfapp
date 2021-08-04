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

namespace App\Services;

use App\Events\StocktakingUpdate;
use App\Factories\StocktakingDataFactory;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class StocktakingService
 *
 * The stocktaking service provides methods updating the current stock.
 *
 * @package App\Services
 */
class StocktakingService
{
    private StocktakingDataFactory $stocktakingDataFactory;

    /**
     * @var Group The group for which to update the stocktaking data
     */
    private Group $group;

    /**
     * @var User The user who performs the update (used for logging)
     */
    private User $actor;

    /**
     * StocktakingService constructor.
     *
     * @param StocktakingDataFactory $stocktakingDataFactory
     */
    public function __construct(StocktakingDataFactory $stocktakingDataFactory)
    {
        $this->stocktakingDataFactory = $stocktakingDataFactory;
    }

    /**
     * Set the group for which to update the stocktaking data.
     *
     * @param Group $group
     * @return $this
     */
    public function setGroup(Group $group): self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Set the user who performs the update (used for logging).
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
     * Updates the stocktaking data with the given data.
     *
     * @param int|null $itemsBought The number of items that were bought
     * @param int $itemsLeft The number of items that were still in stock
     */
    public function update(?int $itemsBought, int $itemsLeft): void
    {
        DB::transaction(function () use ($itemsBought, $itemsLeft) {
            $stocktakingData = $this->group->stocktakingData;

            if ($stocktakingData === null) {
                // Create a new data model if none exists yet
                $stocktakingData = $this->stocktakingDataFactory
                    ->withTotalNumTallies(0)
                    ->withTotalDifference(0)
                    ->withCurrentInventory(0)
                    ->forGroup($this->group)
                    ->create();
            }

            $currentInventory = $stocktakingData->current_inventory;
            $newInventory = $itemsBought + $itemsLeft;
            $relativeDifference = $itemsBought !== null ? $currentInventory - $itemsLeft : 0;

            // Update the data model
            $stocktakingData->total_difference += $relativeDifference;
            $stocktakingData->current_inventory = $newInventory;
            $stocktakingData->save();

            StocktakingUpdate::dispatch($this->group, $this->actor, $itemsBought, $itemsLeft);
        });
    }
}
