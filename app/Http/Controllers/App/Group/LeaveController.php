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
use App\Http\Requests\App\Group\LeaveRequest;
use App\Services\LeaveService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\Factory as ViewFactory;

/**
 * Class LeaveController
 *
 * This class is the controller for the route(s):
 *
 * - /app/group/{group}/leave
 *
 * @package App\Http\Controllers\App\Group
 */
class LeaveController extends AuthenticatedController
{
    private LeaveService $leaveService;

    /**
     * LeaveController constructor.
     *
     * @param LeaveService $leaveService
     * @param ViewFactory $viewFactory
     */
    public function __construct(LeaveService $leaveService, ViewFactory $viewFactory)
    {
        parent::__construct($viewFactory);

        $this->leaveService = $leaveService;
    }

    /**
     * This function is called whenever a POST request is received on this
     * route.
     *
     * @param LeaveRequest $request
     * @return RedirectResponse
     */
    public function leave(LeaveRequest $request): RedirectResponse
    {
        $membership = $request->membership();

        if ($membership->turf_amount > 0) {
            return back()->with('error', __('You cannot leave a group where you have a negative balance.'));
        }

        try {
            $this->leaveService
                ->setMembership($membership)
                ->setActor($request->user())
                ->leave();
        } catch (Exception $exception) {
            return back()->with('error', __('Failed to leave group. Please try again.'));
        }

        return redirect()->route('app');
    }
}
