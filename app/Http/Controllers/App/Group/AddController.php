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
use App\Http\Requests\App\Group\AddRequest;
use App\Models\Group;
use App\Models\GroupJoinCode;
use Illuminate\Contracts\View\View;

/**
 * Class AddController
 *
 * This class is the controller for the route(s):
 *
 * - /app/group/{group}/add
 *
 * @package App\Http\Controllers\App\Group
 */
class AddController extends AuthenticatedController
{
    /**
     * This function is called whenever a GET request is received on this
     * route.
     *
     * @param AddRequest $request
     * @param Group $group
     * @return View
     */
    public function view(AddRequest $request, Group $group): View
    {
        /** @var GroupJoinCode $group_join_code_model */
        $group_join_code_model = $group->groupJoinCode()->firstOrFail();
        $group_join_code = $group_join_code_model->group_join_code;

        return $request->view($this->viewFactory)('web.app.group.add')
            ->with('group_join_code', $group_join_code);
    }
}
