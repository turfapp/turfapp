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
use App\Http\Requests\App\Group\StocktakingEditRequest;
use App\Models\Group;
use App\Services\StocktakingService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\Factory as ViewFactory;

/**
 * Class StocktakingEditController
 *
 * This class is the controller for the route(s):
 *
 * - /app/group/{group}/stocktaking/edit
 *
 * @package App\Http\Controllers\App\Group
 */
class StocktakingEditController extends AuthenticatedController
{
    private StocktakingService $stocktakingService;

    /**
     * StocktakingEditController constructor.
     *
     * @param StocktakingService $stocktakingService
     * @param ViewFactory $viewFactory
     */
    public function __construct(StocktakingService $stocktakingService, ViewFactory $viewFactory)
    {
        parent::__construct($viewFactory);

        $this->stocktakingService = $stocktakingService;
    }

    /**
     * This function is called whenever a GET request is received on
     * this route.
     *
     * @param StocktakingEditRequest $request
     * @param Group $group
     * @return View
     */
    public function view(StocktakingEditRequest $request, Group $group): View
    {
        $stocktakingData = $group->stocktakingData;
        $currentInventory = $stocktakingData !== null ? $stocktakingData->current_inventory : 0;

        return $request->view($this->viewFactory)('web.app.group.stocktaking.edit')
            ->with('current_inventory', $currentInventory);
    }

    /**
     * This function is called whenever a POST request is received on
     * this route.
     *
     * @param StocktakingEditRequest $request
     * @param Group $group
     * @return RedirectResponse
     */
    public function edit(StocktakingEditRequest $request, Group $group): RedirectResponse
    {
        $itemsBought = $request->input('num_items_bought');
        $itemsBought = $itemsBought !== null ? intval($itemsBought) : null;
        $itemsLeft = intval($request->input('num_items_still_in_stock'));

        try {
            $this->stocktakingService
                ->setGroup($group)
                ->setActor($request->user())
                ->update($itemsBought, $itemsLeft);
        } catch (Exception $exception) {
            return back()->with('error', __('Failed to update stock. Please try again.'));
        }

        return redirect()
            ->route('group.stocktaking', $group->group_name)
            ->with('success', __('Successfully updated stock.'));
    }
}
