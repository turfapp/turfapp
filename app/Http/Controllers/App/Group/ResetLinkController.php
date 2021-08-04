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
use App\Http\Requests\App\Group\ResetLinkRequest;
use App\Models\Group;
use App\Services\GroupJoinCodeService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\Factory as ViewFactory;

/**
 * Class ResetLinkController
 *
 * This class is the controller for the route(s):
 *
 * - /app/group/{group}/add/reset
 *
 * @package App\Http\Controllers\App\Group
 */
class ResetLinkController extends AuthenticatedController
{
    private GroupJoinCodeService $groupJoinCodeService;

    /**
     * ResetLinkController constructor.
     *
     * @param GroupJoinCodeService $groupJoinCodeService
     * @param ViewFactory $viewFactory
     */
    public function __construct(GroupJoinCodeService $groupJoinCodeService, ViewFactory $viewFactory)
    {
        parent::__construct($viewFactory);

        $this->groupJoinCodeService = $groupJoinCodeService;
    }

    /**
     * This function is called whenever a POST request is received on this
     * route.
     *
     * @param ResetLinkRequest $request
     * @param Group $group
     * @return RedirectResponse
     */
    public function resetLink(ResetLinkRequest $request, Group $group): RedirectResponse
    {
        try {
            $this->groupJoinCodeService
                ->setGroup($group)
                ->update();
        } catch (Exception $exception) {
            return back()->with('error', __('Failed to reset join link. Please try again.'));
        }

        return back()->with('success', __('Successfully reset join link.'));
    }
}
