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

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AuthenticatedController;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\View\View;

/**
 * Class ConfirmPasswordController
 *
 * @package App\Http\Controllers\Auth
 */
class ConfirmPasswordController extends AuthenticatedController
{
    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
     *
     * @var string
     */
    protected $redirectTo = '/app';

    /**
     * @inheritDoc
     */
    public function showConfirmForm(): View
    {
        return $this->viewFactory->make('web.auth.confirm');
    }
}
