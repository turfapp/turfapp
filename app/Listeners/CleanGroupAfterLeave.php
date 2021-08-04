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

use App\Events\MembershipLeave;

/**
 * Class CleanGroupAfterLeave
 *
 * @package App\Listeners
 */
class CleanGroupAfterLeave implements Listener
{
    /**
     * Handle the event.
     *
     * @param MembershipLeave $event
     * @return void
     */
    public function handle($event): void
    {
        $group = $event->getMembership()->group;
        $group_memberships = $group->memberships;

        if ($group_memberships->count() === 0) {
            // Delete the associated join code
            $group->groupJoinCode()->delete();
            // Delete all logs associated with this group
            $group->turfLogs()->delete();
            // Delete all settings associated with this group
            $group->settings()->delete();
            // Delete associated stocktaking data
            $group->stocktakingData()->delete();

            // Delete the group if the last member just left
            $group->delete();
        } elseif ($group_memberships->where('member_is_admin', true)->count() === 0) {
            // Make the person who has been in the group the longest the
            // admin if the last admin just left
            $oldest_member = $group_memberships
                ->sortBy('member_join_timestamp')
                ->first();

            $oldest_member->member_is_admin = true;
            $oldest_member->save();
        }
    }
}
