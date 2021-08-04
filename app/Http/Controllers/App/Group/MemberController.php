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
use App\Http\Helpers\LogItems;
use App\Http\Requests\App\Group\MemberRequest;
use App\Models\Group;
use App\Models\User;
use App\Repositories\GroupSettingRepository;
use Illuminate\Contracts\View\View;
use Illuminate\View\Factory as ViewFactory;

/**
 * Class MemberController
 *
 * This class is the controller for the route(s):
 *
 * - /app/group/{group}/member/{user}
 *
 * @package App\Http\Controllers\App\Group
 */
class MemberController extends AuthenticatedController
{
    use LogItems;

    private GroupSettingRepository $groupSettingRepository;

    /**
     * MemberController constructor.
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
     * @param MemberRequest $request
     * @param Group $group
     * @param User $user
     * @return View
     */
    public function view(MemberRequest $request, Group $group, User $user): View
    {
        $membership = $group->get($user);

        $logItems = $membership->user->receiverTurfLogs->where('group_id', '=', $group->id);
        $shownLogItems = $logItems->sortByDesc('created_at')->take(250);

        $tallyPrice = $this->groupSettingRepository->getSettingOrDefault('price_per_tally', $membership->group);
        $outstandingBalance = $membership->turf_amount * $tallyPrice;

        return $request->view($this->viewFactory)('web.app.group.member')
            ->with('membership', $membership)
            ->with('outstanding_balance', $outstandingBalance)
            ->with('log_date_groups', $this->groupLogItemsByDate($shownLogItems))
            ->with('num_log_items', $logItems->count())
            ->with('num_log_items_shown', $shownLogItems->count());
    }
}
