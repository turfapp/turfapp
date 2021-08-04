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

namespace App\Http\Controllers\App\Group;

use App\Http\Controllers\AuthenticatedController;
use App\Http\Helpers\LogItems;
use App\Http\Requests\App\Group\LogRequest;
use App\Models\Group;
use Illuminate\Contracts\View\View;

/**
 * Class LogController
 *
 * This class is the controller for the route(s):
 *
 * - /app/group/{group}/logs
 *
 * @package App\Http\Controllers\App\Group
 */
class LogController extends AuthenticatedController
{
    use LogItems;

    private const SHOWN_LOG_ITEMS_LIMIT = 250;

    /**
     * This function is called whenever a GET request is received on
     * this route.
     *
     * @param LogRequest $request
     * @param Group $group
     * @return View
     */
    public function view(LogRequest $request, Group $group): View
    {
        $shownLogItems = $group->turfLogs
            ->sortByDesc('created_at')
            ->take(self::SHOWN_LOG_ITEMS_LIMIT);

        return $request->view($this->viewFactory)('web.app.group.log')
            ->with('log_date_groups', $this->groupLogItemsByDate($shownLogItems))
            ->with('num_log_items', $group->turfLogs()->count())
            ->with('num_log_items_shown', $shownLogItems->count());
    }
}
