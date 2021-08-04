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
use App\Http\Requests\App\Group\JoinRequest;
use App\Models\Group;
use App\Models\GroupJoinCode;
use App\Services\JoinGroupService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Factory as ViewFactory;
use Illuminate\View\View;

/**
 * Class JoinController
 *
 * This class is the controller for the route(s):
 *
 * - /app/group/{group}/join/{group_join_code}
 *
 * @package App\Http\Controllers\App\Group
 */
class JoinController extends AuthenticatedController
{
    private JoinGroupService $joinGroupService;

    /**
     * JoinController constructor.
     *
     * @param JoinGroupService $joinGroupService
     * @param ViewFactory $viewFactory
     */
    public function __construct(JoinGroupService $joinGroupService, ViewFactory $viewFactory)
    {
        parent::__construct($viewFactory);

        $this->joinGroupService = $joinGroupService;
    }

    /**
     * This function is called whenever a GET request is received on this
     * route.
     *
     * @param JoinRequest $request
     * @param Group $group
     * @param string $request_join_code
     * @return View|RedirectResponse
     */
    public function view(JoinRequest $request, Group $group, string $request_join_code): View|RedirectResponse
    {
        /** @var GroupJoinCode $group_join_code_model */
        $group_join_code_model = $group->groupJoinCode()->firstOrFail();
        $group_join_code = $group_join_code_model->group_join_code;

        if (!hash_equals($group_join_code, $request_join_code)) {
            // The join code is invalid
            return view('web.app.group.join.invalid')->with('logged_user', Auth::user());
        }

        if ($group->has($request->user())) {
            // The user is already in this group
            return redirect()->route('group.overview', $group->group_name);
        }

        return $this->viewFactory
            ->make('web.app.group.join.confirm')
            ->with('logged_user', $request->user())
            ->with('group_to_join', $group)
            ->with('group_join_code', $request_join_code);
    }

    /**
     * This function is called whenever a POST request is received on this
     * route.
     *
     * @param JoinRequest $request
     * @param Group $group
     * @param string $join_code
     * @return RedirectResponse
     */
    public function join(JoinRequest $request, Group $group, string $join_code): RedirectResponse
    {
        if ($group->has($request->user())) {
            // The user is already in this group
            return back()->with('error', __('Failed to join group, because you are already a member.'));
        }

        /** @var GroupJoinCode $group_join_code_model */
        $group_join_code_model = $group->groupJoinCode()->firstOrFail();
        $group_join_code = $group_join_code_model->group_join_code;

        if (!hash_equals($group_join_code, $join_code)) {
            // The join code is invalid
            return back()
                ->with('error', __('Failed to join group, because the join link is not, or no longer, valid.'));
        }

        try {
            $this->joinGroupService->setGroup($group)->setUser($request->user())->join();
        } catch (Exception $exception) {
            return back()->with('error', __('Failed to join group. Please try again.'));
        }

        return redirect()->route('group.overview', $group->group_name);
    }
}
