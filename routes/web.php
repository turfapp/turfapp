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

use App\Http\Controllers\App\Group\AddController;
use App\Http\Controllers\App\Group\DemoteController;
use App\Http\Controllers\App\Group\JoinController;
use App\Http\Controllers\App\Group\KickController;
use App\Http\Controllers\App\Group\LeaveController;
use App\Http\Controllers\App\Group\LogController;
use App\Http\Controllers\App\Group\MemberController;
use App\Http\Controllers\App\Group\OverviewController;
use App\Http\Controllers\App\Group\PromoteController;
use App\Http\Controllers\App\Group\ResetController;
use App\Http\Controllers\App\Group\ResetLinkController;
use App\Http\Controllers\App\Group\SettingsController;
use App\Http\Controllers\App\Group\StocktakingController;
use App\Http\Controllers\App\Group\StocktakingEditController;
use App\Http\Controllers\App\Groups\NewController;
use App\Http\Controllers\App\IndexController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

// Index route
Route::get('/', [\App\Http\Controllers\IndexController::class, 'view'])->name('index');

// Authentication routes
Route::prefix('/auth')->group(function () {
    Route::get('/login', [LoginController::class, 'view'])->name('auth.login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');

    Route::get('/password/reset', [ForgotPasswordController::class, 'view'])->name('auth.password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset']);
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'view'])->name('auth.password.reset.token');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('auth.password.email');

    Route::get('/register', [RegisterController::class, 'view'])->name('auth.register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// App index route
Route::get('/app', [IndexController::class, 'view'])->name('app');

// Groups routes
Route::prefix('/app/groups')->group(function () {
    Route::get('/new', [NewController::class, 'view'])->name('groups.new');
    Route::post('/new', [NewController::class, 'add']);
});

// Specific group routes
Route::prefix('/app/group/{group}')->group(function () {
    Route::get('/add', [AddController::class, 'view'])->name('group.add');
    Route::post('/add/reset', [ResetLinkController::class, 'resetLink'])->name('group.add.reset');

    Route::get('/join/{groupjoincode}', [JoinController::class, 'view'])->name('group.join');
    Route::post('/join/{groupjoincode}', [JoinController::class, 'join']);

    Route::post('/leave', [LeaveController::class, 'leave'])->name('group.leave');

    Route::get('/logs', [LogController::class, 'view'])->name('group.logs');

    Route::get('/member/{user}', [MemberController::class, 'view'])->name('group.member');
    Route::post('/member/{user}/demote', [DemoteController::class, 'demote'])->name('group.member.demote');
    Route::post('/member/{user}/kick', [KickController::class, 'kick'])->name('group.member.kick');
    Route::post('/member/{user}/promote', [PromoteController::class, 'promote'])->name('group.member.promote');
    Route::post('/member/{user}/reset', [ResetController::class, 'reset'])->name('group.member.reset');

    Route::get('/overview', [OverviewController::class, 'view'])->name('group.overview');

    Route::get('/settings', [SettingsController::class, 'view'])->name('group.settings');
    Route::post('/settings', [SettingsController::class, 'update']);

    Route::get('/stocktaking', [StocktakingController::class, 'view'])->name('group.stocktaking');
    Route::get('/stocktaking/edit', [StocktakingEditController::class, 'view'])->name('group.stocktaking.edit');
    Route::post('/stocktaking/edit', [StocktakingEditController::class, 'edit']);
});
