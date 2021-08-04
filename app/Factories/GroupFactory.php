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

namespace App\Factories;

use App\Models\Group;
use App\Repositories\GroupRepository;
use Illuminate\Support\Str;

/**
 * Class GroupFactory
 *
 * This class is responsible for creating Group models.
 *
 * @package App\Factories
 */
class GroupFactory implements Factory
{
    /**
     * @var string The display name of the group
     */
    private string $displayName;

    /**
     * @var GroupRepository The group repository that is used to generate a unique group name
     */
    private GroupRepository $groupRepository;

    /**
     * GroupFactory constructor.
     *
     * @param GroupRepository $groupRepository The group repository that is used to generate a unique group name
     */
    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * Set the display name of the group.
     *
     * @param string $displayName
     * @return GroupFactory
     */
    public function withDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Creates the Group model.
     *
     * @return Group
     */
    public function create(): Group
    {
        $object = new Group();

        $object->group_name = $this->generateGroupName();
        $object->group_display_name = $this->displayName;

        return $object;
    }

    /**
     * Generates a unique group name.
     *
     * @return string
     */
    private function generateGroupName(): string
    {
        // Keep generating a group name until we find one that is not yet taken
        do {
            $part_a = Str::random(14);
            $part_b = Str::random(8);
            $part_c = Str::random(8);

            $name = implode('-', [$part_a, $part_b, $part_c]);
        } while ($this->groupRepository->getFromGroupName($name)->exists());

        return $name;
    }
}
