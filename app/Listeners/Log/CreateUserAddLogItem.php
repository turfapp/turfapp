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

namespace App\Listeners\Log;

use App\Events\GroupJoin;

/**
 * Class CreateUserAddLogItem
 *
 * @package App\Listeners
 */
class CreateUserAddLogItem extends LoggingListener
{
    /**
     * Handle the event.
     *
     * @param GroupJoin $event
     * @return void
     */
    public function handle($event): void
    {
        $membership = $event->getMembership();

        $this->logFactory
            ->withType('useradd')
            ->withReceiver($membership->user)
            ->forGroup($membership->group)
            ->withActor($event->getMembership()->user)
            ->create()
            ->save();
    }
}
