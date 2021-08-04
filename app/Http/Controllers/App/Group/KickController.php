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
use App\Http\Requests\App\Group\KickRequest;
use App\Models\Group;
use App\Models\User;
use App\Services\KickService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\Factory as ViewFactory;

/**
 * Class KickController
 *
 * This class is the controller for the route(s):
 *
 * - /app/group/{group}/member/{user}/kick
 *
 * @package App\Http\Controllers\App\Group
 */
class KickController extends AuthenticatedController
{
    private KickService $kickService;

    /**
     * KickController constructor.
     *
     * @param KickService $kickService
     * @param ViewFactory $viewFactory
     */
    public function __construct(KickService $kickService, ViewFactory $viewFactory)
    {
        parent::__construct($viewFactory);

        $this->kickService = $kickService;
    }

    /**
     * This function is called whenever a POST request is received on this
     * route.
     *
     * @param KickRequest $request
     * @param Group $group
     * @param User $user
     * @return RedirectResponse
     */
    public function kick(KickRequest $request, Group $group, User $user): RedirectResponse
    {
        $actor = $request->user();
        $membership = $group->get($user);

        if ($membership->user->id === $actor->id) {
            return back()->with('error', __('You cannot kick yourself.'));
        }

        try {
            $this->kickService
                ->setMembership($membership)
                ->setActor($actor)
                ->kick();
        } catch (Exception $exception) {
            return back()->with('error', __('Failed to kick user. Please try again.'));
        }

        $success_message_params = ['username' => $membership->user->name, 'group' => $group->group_display_name];
        $success_message = __('Successfully kicked :username from :group.', $success_message_params);

        return redirect()
            ->route('group.overview', ['group' => $group->group_name])
            ->with('success', $success_message);
    }
}
