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
use App\Http\Requests\App\Group\DemoteRequest;
use App\Models\Group;
use App\Models\User;
use App\Services\GroupAdminService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\Factory as ViewFactory;

/**
 * Class DemoteController
 *
 * This class is the controller for the route(s):
 *
 * - /app/group/{group}/member/{user}/demote
 *
 * @package App\Http\Controllers\App\Group
 */
class DemoteController extends AuthenticatedController
{
    private GroupAdminService $groupAdminService;

    /**
     * DemoteController constructor.
     *
     * @param GroupAdminService $groupAdminService
     * @param ViewFactory $viewFactory
     */
    public function __construct(GroupAdminService $groupAdminService, ViewFactory $viewFactory)
    {
        parent::__construct($viewFactory);

        $this->groupAdminService = $groupAdminService;
    }

    /**
     * This function is called whenever a POST request is received on this
     * route.
     *
     * This function does nothing if the user is not an admin.
     *
     * @param DemoteRequest $request
     * @param Group $group
     * @param User $user
     * @return RedirectResponse
     */
    public function demote(DemoteRequest $request, Group $group, User $user): RedirectResponse
    {
        $membership = $group->get($user);

        if ($membership->user->id === $request->user()->id) {
            return back()->with('error', __('You cannot demote yourself.'));
        }

        try {
            $this->groupAdminService
                ->setMembership($membership)
                ->setActor($request->user())
                ->demote();
        } catch (Exception $exception) {
            return back()->with('error', __('Failed to demote user. Please try again.'));
        }

        return back()->with(
            'success',
            __('Successfully demoted :username to user.', ['username' => $membership->user->name])
        );
    }
}
