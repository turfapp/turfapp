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

namespace App\Http\Requests;

use App\Models\Group;
use App\Models\Membership;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\View\Factory as ViewFactory;
use Illuminate\View\View;

/**
 * Class GroupRequest
 *
 * This is the base class for all requests to a group.
 *
 * @package App\Http\Requests
 */
abstract class GroupRequest extends AppRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorizeAll(): bool
    {
        return $this->user()->can('view', $this->group());
    }

    /**
     * Returns the membership for the current user.
     *
     * @return Membership
     * @throws ModelNotFoundException If the model does not exist
     */
    final public function membership(): Membership
    {
        return $this->group()->get($this->user());
    }

    /**
     * Constructs a base view for the current request. Will return a callable that takes a
     * view name and return a View object with the following parameters already filled in:
     *
     * - logged_user
     * - logged_user_membership
     * - group
     *
     * We use the parent to fill in the 'logged_user' variable.
     *
     * @see parent::view()
     *
     * @return callable(string): View
     */
    public function view(ViewFactory $factory): callable
    {
        return function (string $viewName) use ($factory) {
            return parent::view($factory)($viewName)
                ->with('logged_user_membership', $this->membership())
                ->with('group', $this->group());
        };
    }

    /**
     * Accessor for the group attribute.
     *
     * @return Group
     */
    final public function group(): Group
    {
        if (!isset($this->group)) {
            throw new ModelNotFoundException();
        }

        if (is_string($this->group)) {
            // The service container may not always resolve the group attribute; in case it didn't, we do it ourselves
            $this->group = Group::where('group_name', $this->group)->firstOrFail();
        }

        return $this->group;
    }
}
