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
use App\Http\Requests\App\Group\ResetRequest;
use App\Models\Group;
use App\Models\User;
use App\Services\BalanceService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\Factory as ViewFactory;

/**
 * Class ResetController
 *
 * This class is the controller for the route(s):
 *
 * - /app/group/{group}/member/{user}/reset
 *
 * @package App\Http\Controllers\App\Group
 */
class ResetController extends AuthenticatedController
{
    private BalanceService $balanceService;

    /**
     * ResetController constructor.
     *
     * @param ViewFactory $viewFactory
     * @param BalanceService $balanceService
     */
    public function __construct(ViewFactory $viewFactory, BalanceService $balanceService)
    {
        parent::__construct($viewFactory);

        $this->balanceService = $balanceService;
    }

    /**
     * This function is called whenever a POST request is received on this
     * route.
     *
     * @param ResetRequest $request
     * @param Group $group
     * @param User $user
     * @return RedirectResponse
     */
    public function reset(ResetRequest $request, Group $group, User $user): RedirectResponse
    {
        $membership = $group->get($user);

        try {
            $this->balanceService
                ->setMembership($membership)
                ->setActor($request->user())
                ->reset();
        } catch (Exception $exception) {
            return back()->with('error', __("Failed to reset tally's. Please try again."));
        }

        return redirect()
            ->route('group.member', ['group' => $group, 'user' => $user])
            ->with('success', __(
                "Successfully set the outstanding tally's of :username to zero.",
                ['username' => $membership->user->name]
            ));
    }
}
