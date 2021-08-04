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

namespace App\Providers;

use App\Events\Balance\BalanceDecrement;
use App\Events\Balance\BalanceIncrement;
use App\Events\Balance\BalanceReset;
use App\Events\Balance\BalanceSet;
use App\Events\GroupJoin;
use App\Events\GroupSettingsUpdate;
use App\Events\MembershipDemote;
use App\Events\MembershipKick;
use App\Events\MembershipLeave;
use App\Events\MembershipPromote;
use App\Events\StocktakingUpdate;
use App\Listeners\CleanGroupAfterLeave;
use App\Listeners\CreateBalanceAggregation;
use App\Listeners\Log\CreateBalanceDecrementLogItem;
use App\Listeners\Log\CreateBalanceIncrementLogItem;
use App\Listeners\Log\CreateBalanceResetLogItem;
use App\Listeners\Log\CreateStocktakingUpdateLogItem;
use App\Listeners\Log\CreateUpdateSettingsLogItem;
use App\Listeners\Log\CreateUserAddLogItem;
use App\Listeners\Log\CreateUserDeleteLogItem;
use App\Listeners\Log\CreateUserDemoteLogItem;
use App\Listeners\Log\CreateUserLeaveLogItem;
use App\Listeners\Log\CreateUserPromoteLogItem;
use App\Listeners\UpdateStocktakingData;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 *
 * @package App\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        BalanceDecrement::class => [
            CreateBalanceDecrementLogItem::class,
            CreateBalanceAggregation::class,
            UpdateStocktakingData::class
        ],
        BalanceIncrement::class => [
            CreateBalanceIncrementLogItem::class,
            CreateBalanceAggregation::class,
            UpdateStocktakingData::class
        ],
        BalanceReset::class => [
            CreateBalanceResetLogItem::class
        ],
        BalanceSet::class => [],
        GroupJoin::class => [
            CreateUserAddLogItem::class
        ],
        GroupSettingsUpdate::class => [
            CreateUpdateSettingsLogItem::class
        ],
        MembershipDemote::class => [
            CreateUserDemoteLogItem::class
        ],
        MembershipKick::class => [
            CreateUserDeleteLogItem::class
        ],
        MembershipLeave::class => [
            CleanGroupAfterLeave::class,
            CreateUserLeaveLogItem::class
        ],
        MembershipPromote::class => [
            CreateUserPromoteLogItem::class
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        StocktakingUpdate::class => [
            CreateStocktakingUpdateLogItem::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
    }
}
