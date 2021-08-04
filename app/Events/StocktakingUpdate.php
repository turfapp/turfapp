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
 * Class StocktakingUpdate
 *
 * This event is fired whenever someone updates the stock.
 *
 * @package App\Events\Group
 */
class StocktakingUpdate implements Event
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    private Group $group;
    private User $actor;
    private ?int $itemsBought;
    private int $itemsLeft;

    /**
     * @param Group $group The group for which the stocktaking data was updated
     * @param User $actor The user who performed the update
     * @param int|null $itemsBought The number of items that were bought
     * @param int $itemsLeft The number of items that were still in stock
     */
    public function __construct(Group $group, User $actor, ?int $itemsBought, int $itemsLeft)
    {
        $this->group = $group;
        $this->actor = $actor;
        $this->itemsBought = $itemsBought;
        $this->itemsLeft = $itemsLeft;
    }

    /**
     * Returns the group for which the stocktaking data was updated.
     *
     * @return Group
     */
    public function getGroup(): Group
    {
        return $this->group;
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
     * Returns the number of items bought, or NULL if the field was left empty (dry update).
     *
     * @return int|null
     */
    public function getItemsBought(): ?int
    {
        return $this->itemsBought;
    }

    /**
     * Returns the number of items that were still in stock before the update. This number is
     * given by the user updating the stocktaking data.
     *
     * @return int
     */
    public function getItemsLeft(): int
    {
        return $this->itemsLeft;
    }

    /**
     * @inheritDoc
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('turfapp');
    }
}
