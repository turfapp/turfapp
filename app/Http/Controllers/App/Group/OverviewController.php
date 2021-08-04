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
use App\Http\Requests\App\Group\OverviewRequest;
use App\Models\Group;
use App\Repositories\GroupSettingRepository;
use Illuminate\Contracts\View\View;
use Illuminate\View\Factory as ViewFactory;

/**
 * Class OverviewController
 *
 * This class is the controller for the route(s):
 *
 * - /app/group/{group}/overview
 *
 * @package App\Http\Controllers\App\Group
 */
class OverviewController extends AuthenticatedController
{
    private GroupSettingRepository $groupSettingRepository;

    /**
     * OverviewController constructor.
     *
     * @param GroupSettingRepository $groupSettingRepository
     * @param ViewFactory $viewFactory
     */
    public function __construct(GroupSettingRepository $groupSettingRepository, ViewFactory $viewFactory)
    {
        parent::__construct($viewFactory);

        $this->groupSettingRepository = $groupSettingRepository;
    }

    /**
     * This function is called whenever a GET request is received on
     * this route.
     *
     * @param OverviewRequest $request
     * @param Group $group
     * @return View
     */
    public function view(OverviewRequest $request, Group $group): View
    {
        $membersExcludingCurrent = $group->memberships
            ->where('user_id', '!=', $request->user()->id)
            ->sortByDesc('turf_amount');

        return $request->view($this->viewFactory)('web.app.group.overview')
            ->with('members_excluding_current_viewer', $membersExcludingCurrent)
            ->with('total_open_amount', $this->totalOpenAmount($group));
    }

    /**
     * Calculates the total open amount for the given group.
     *
     * @param Group $group
     * @return float
     */
    private function totalOpenAmount(Group $group): float
    {
        $tallyPrice = $this->groupSettingRepository->getSettingOrDefault('price_per_tally', $group);
        $reducer = fn ($carry, $model) => $carry + ($model['turf_amount'] * $tallyPrice);

        return array_reduce($group->memberships->toArray(), $reducer, 0);
    }
}
