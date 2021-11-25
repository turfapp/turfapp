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

use Illuminate\View\Factory as ViewFactory;
use Illuminate\View\View;

/**
 * Class AppRequest
 *
 * Base class for all request classes in the application.
 *
 * @package App\Http\Requests
 */
abstract class AppRequest extends BaseRequest
{
    /**
     * Constructs a base view for the current request. Will return a callable that takes a
     * view name and return a View object with the following parameter(s) already filled in:
     *
     * - logged_user
     *
     * @return callable(string): View
     */
    public function view(ViewFactory $factory): callable
    {
        return function (string $viewName) use ($factory) {
            return parent::view($factory)($viewName)->with('logged_user', $this->user());
        };
    }
}
