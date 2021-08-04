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

namespace App\Http\Controllers\App\Groups;

use App\Http\Controllers\AuthenticatedController;
use App\Http\Requests\App\Groups\NewRequest;
use App\Services\CreateGroupService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\Factory as ViewFactory;

/**
 * Class NewController
 *
 * This class is the controller for the route(s):
 *
 * - /app/groups/new/
 *
 * @package App\Http\Controllers\App\Groups
 */
class NewController extends AuthenticatedController
{
    private CreateGroupService $createGroupService;

    /**
     * NewController constructor.
     *
     * @param ViewFactory $viewFactory
     * @param CreateGroupService $createGroupService
     */
    public function __construct(ViewFactory $viewFactory, CreateGroupService $createGroupService)
    {
        parent::__construct($viewFactory);

        $this->createGroupService = $createGroupService;
    }

    /**
     * This function is called whenever a GET request is received on
     * this route.
     *
     * @param NewRequest $request
     * @return View
     */
    public function view(NewRequest $request): View
    {
        return $request->view($this->viewFactory)('web.app.groups.new');
    }

    /**
     * This function is called whenever a PUT request is received on
     * this route.
     *
     * @param NewRequest $request
     * @return RedirectResponse
     */
    public function add(NewRequest $request): RedirectResponse
    {
        $display_name = trim($request->validated()['group_display_name'], ' ');

        try {
            $group = $this->createGroupService
                ->setDisplayName($display_name)
                ->setUser($request->user())
                ->create();
        } catch (Exception $exception) {
            return back()->with('error', __('Failed to create group. Please try again.'));
        }

        return redirect()->route('group.overview', $group->group_name);
    }
}
