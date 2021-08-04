<?php

/*
 * TurfApp - TurfApp - An alternative for paper tally lists.
 *  Copyright (C) 2021  Marijn van Wezel
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

namespace App\Services;

use App\Events\GroupSettingsUpdate;
use App\Factories\GroupSettingFactory;
use App\Models\Group;
use App\Models\User;
use App\Repositories\GroupSettingRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class JoinGroupService
 *
 * The join group service provides methods for joining a group. It also handles event broadcasting.
 *
 * @package App\Services
 */
class GroupSettingsService
{
    private Group $group;
    private GroupSettingRepository $groupSettingRepository;
    private GroupSettingFactory $groupSettingFactory;
    private User $actor;

    /**
     * JoinGroupService constructor.
     *
     * @param GroupSettingRepository $groupSettingRepository
     * @param GroupSettingFactory $groupSettingFactory
     */
    public function __construct(
        GroupSettingRepository $groupSettingRepository,
        GroupSettingFactory $groupSettingFactory
    ) {
        $this->groupSettingRepository = $groupSettingRepository;
        $this->groupSettingFactory = $groupSettingFactory;
    }

    /**
     * Set the group for which to update the settings.
     *
     * @param Group $group
     * @return $this
     */
    public function setGroup(Group $group): self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Set the user who performs the update.
     *
     * @param User $actor
     * @return $this
     */
    public function setActor(User $actor): self
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * Update the given settings to the specified values.
     *
     * @param array $settings
     * @return void
     */
    public function update(array $settings): void
    {
        DB::transaction(function () use ($settings) {
            if (!$this->hasChanges($settings)) {
                return;
            }

            foreach ($settings as $settingName => $settingValue) {
                $this->updateSetting($settingName, $settingValue);
            }

            GroupSettingsUpdate::dispatch($this->group, $this->actor);
        });
    }

    /**
     * Update the given setting to the given value.
     *
     * @param string $settingName
     * @param mixed $settingValue
     */
    private function updateSetting(string $settingName, mixed $settingValue): void
    {
        $existingModel = $this->group
            ->settings()
            ->where('group_setting_name', $settingName);

        if ($existingModel->count() > 0) {
            $existingModel->delete();
        }

        $this->groupSettingFactory
            ->forGroup($this->group)
            ->withName($settingName)
            ->withValue($settingValue)
            ->create()
            ->save();
    }

    /**
     * Returns whether the given settings are different from the current settings.
     *
     * @param array $settings
     * @return bool
     */
    private function hasChanges(array $settings): bool
    {
        foreach ($settings as $settingName => $newValue) {
            $currentValue = $this->groupSettingRepository
                ->getSettingOrDefault($settingName, $this->group);

            if ($newValue !== $currentValue) {
                return true;
            }
        }

        return false;
    }
}
