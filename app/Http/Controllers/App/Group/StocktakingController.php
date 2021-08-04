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
use App\Http\Requests\App\Group\StocktakingRequest;
use App\Models\Group;
use App\Repositories\GroupSettingRepository;
use Illuminate\Contracts\View\View;
use Illuminate\View\Factory as ViewFactory;

/**
 * Class StocktakingController
 *
 * This class is the controller for the route(s):
 *
 * - /app/group/{group}/stocktaking
 *
 * @package App\Http\Controllers\App\Group
 */
class StocktakingController extends AuthenticatedController
{
    private GroupSettingRepository $groupSettingRepository;

    /**
     * StocktakingController constructor.
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
     * @param StocktakingRequest $request
     * @param Group $group
     * @return View
     */
    public function view(StocktakingRequest $request, Group $group): View
    {
        // Get the stocktaking data model from the group the user is looking at
        $stocktakingData = $group->stocktakingData;

        $discrepancy_percentage = $stocktakingData?->discrepancy ?? '--';
        $current_inventory = $stocktakingData?->current_inventory ?? 0;

        $price_per_tally = $this->groupSettingRepository->getSettingOrDefault('price_per_tally', $group);
        $lost_money = ($stocktakingData?->total_difference ?? 0) * $price_per_tally;

        // Construct and return the view
        return $request
            ->view($this->viewFactory)('web.app.group.stocktaking.stocktaking')
            ->with('discrepancy', $discrepancy_percentage)
            ->with('current_inventory', $current_inventory)
            ->with('lost_money', $lost_money);
    }
}
