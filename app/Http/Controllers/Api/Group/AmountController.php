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

namespace App\Http\Controllers\Api\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Group\AmountRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\BalanceService;
use Exception;
use Illuminate\Http\Response;
use Illuminate\View\Factory as ViewFactory;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class AmountController
 *
 * This class is the controller for the route(s):
 *
 * - /api/group/{group}/amount
 *
 * @package App\Http\Controllers\Api\Group
 */
class AmountController extends Controller
{
    private UserRepository $userRepository;
    private BalanceService $balanceService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ViewFactory $viewFactory,
        UserRepository $userRepository,
        BalanceService $balanceService
    ) {
        $this->middleware('auth:sanctum');
        $this->middleware('throttle:turf');

        $this->userRepository = $userRepository;
        $this->balanceService = $balanceService;

        parent::__construct($viewFactory);
    }

    /**
     * This function is called whenever a PUT request is received
     * on this route.
     *
     * @param AmountRequest $request The current request context
     * @return Response
     */
    public function update(AmountRequest $request): Response
    {
        $fields = $request->validated();

        /** @var User $user */
        $user = $this->userRepository->getFromId(intval($fields['receiver']))->firstOrFail();

        // Inject the membership into the balance service
        $this->balanceService
            ->setMembership($request->group()->get($user))
            ->setActor($request->user());

        try {
            $fields['operation'] === 'increment' ?
                $this->balanceService->increment() :
                $this->balanceService->decrement();
        } catch (Exception $exception) {
            return response('', ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response('', ResponseAlias::HTTP_NO_CONTENT);
    }
}
