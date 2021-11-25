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
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\Factory as ViewFactory;
use Illuminate\View\View;

/**
 * Class RegisterController
 *
 * This class is the controller for the route(s):
 *
 * - /auth/register
 *
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected string $redirectTo = '/app';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data): User
    {
        return User::create([
            'name' => trim($data['name'], ' '),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Show the application's registration form.
     *
     * @param PublicRequest $request
     * @return View
     */
    public function view(PublicRequest $request): View
    {
        return $request->view($this->viewFactory)('web.auth.register');
    }

    /**
     * @inheritDoc
     */
    public function showRegistrationForm(PublicRequest $request): View
    {
        return $this->view($request);
    }
}
