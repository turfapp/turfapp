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
use App\Http\Requests\App\Group\SettingsRequest;
use App\Models\Group;
use App\Repositories\GroupSettingRepository;
use App\Services\GroupSettingsService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\Factory as ViewFactory;

/**
 * Class SettingsController
 *
 * This class is the controller for the route(s):
 *
 * - /app/group/{group}/settings
 *
 * @package App\Http\Controllers\App\Group
 */
class SettingsController extends AuthenticatedController
{
    private GroupSettingsService $groupSettingsService;
    private GroupSettingRepository $groupSettingRepository;

    /**
     * SettingsController constructor.
     *
     * @param GroupSettingsService $groupSettingsService
     * @param GroupSettingRepository $groupSettingRepository
     * @param ViewFactory $viewFactory
     */
    public function __construct(
        GroupSettingsService $groupSettingsService,
        GroupSettingRepository $groupSettingRepository,
        ViewFactory $viewFactory
    ) {
        parent::__construct($viewFactory);

        $this->groupSettingsService = $groupSettingsService;
        $this->groupSettingRepository = $groupSettingRepository;
    }

    /**
     * This function is called whenever a GET request is received on
     * this route.
     *
     * @param SettingsRequest $request
     * @param Group $group
     * @return View
     */
    public function view(SettingsRequest $request, Group $group): View
    {
        $price_per_tally = $this->groupSettingRepository
            ->getSettingOrDefault('price_per_tally', $group);

        return $request->view($this->viewFactory)('web.app.group.settings')
            ->with('price_per_tally', $price_per_tally);
    }

    /**
     * This function is called whenever a POST request is received on
     * this route.
     *
     * @param SettingsRequest $request
     * @return RedirectResponse
     */
    public function update(SettingsRequest $request): RedirectResponse
    {
        $fields = $request->validated();

        $settings = [
            'price_per_tally' => floatval($fields['price_per_tally'])
        ];

        try {
            $this->groupSettingsService
                ->setActor($request->user())
                ->setGroup($request->group())
                ->update($settings);
        } catch (Exception $exception) {
            return back()->with('error', __('Failed to update group settings. Please try again.'));
        }

        return back()->with('success', __('Successfully updated the group settings.'));
    }
}
