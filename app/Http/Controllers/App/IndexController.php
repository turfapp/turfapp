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

namespace App\Http\Controllers\App;

use App\Http\Controllers\AuthenticatedController;
use App\Http\Requests\App\IndexRequest;
use Illuminate\Contracts\View\View;

/**
 * Class IndexController
 *
 * This class is the controller for the route(s):
 *
 * - /app/
 *
 * @package App\Http\Controllers\App
 */
class IndexController extends AuthenticatedController
{
    /**
     * This function is called whenever a GET request is received on
     * this route.
     *
     * @param IndexRequest $request The current request context
     * @return View
     */
    public function view(IndexRequest $request): View
    {
        return $request->view($this->viewFactory)('web.app.index');
    }
}
