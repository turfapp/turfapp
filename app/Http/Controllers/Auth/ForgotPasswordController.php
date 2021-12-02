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

use App\Http\Controllers\Controller;
use App\Http\Requests\PublicRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\View\Factory as ViewFactory;
use Illuminate\View\View;

/**
 * Class ForgotPasswordController
 *
 * This class is the controller for the route(s):
 *
 * - /auth/password/reset
 * - /auth/password/email
 *
 * @package App\Http\Controllers\Auth
 */
class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ViewFactory $viewFactory)
    {
        $this->middleware('guest');

        parent::__construct($viewFactory);
    }

    /**
     * Display the form to request a password reset link.
     *
     * @param PublicRequest $request
     * @return View
     */
    public function view(PublicRequest $request): View
    {
        return $request->view($this->viewFactory)('web.auth.email-reset-link');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @param PublicRequest $request
     * @return View
     */
    public function showLinkRequestForm(PublicRequest $request): View
    {
        return $this->view($request);
    }
}
