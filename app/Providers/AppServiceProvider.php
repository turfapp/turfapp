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

use App\Factories\AggregationFactory;
use App\Factories\GroupFactory;
use App\Factories\GroupJoinCodeFactory;
use App\Factories\GroupSettingFactory;
use App\Factories\LogFactory;
use App\Factories\MembershipFactory;
use App\Factories\StocktakingDataFactory;
use App\Repositories\GroupRepository;
use App\Repositories\GroupSettingRepository;
use App\Repositories\MembershipRepository;
use App\Repositories\UserRepository;
use App\Services\BalanceService;
use App\Services\CreateGroupService;
use App\Services\GroupAdminService;
use App\Services\GroupJoinCodeService;
use App\Services\GroupSettingsService;
use App\Services\JoinGroupService;
use App\Services\StocktakingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->bindRepositories();
        $this->bindFactories();
        $this->bindServices();

        parent::register();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        setlocale(LC_TIME, Config::get('app.lc_all'));
        Carbon::setLocale(Config::get('app.locale'));

        $this->bootstrapComponents();
        $this->bootstrapBladeDirectives();
    }

    /**
     * Binds necessary repositories.
     */
    private function bindRepositories(): void
    {
        $this->app->bind(UserRepository::class, static function () {
            return new UserRepository();
        });

        $this->app->bind(GroupRepository::class, static function () {
            return new GroupRepository();
        });

        $this->app->bind(MembershipRepository::class, static function () {
            return new MembershipRepository();
        });

        $this->app->bind(GroupSettingRepository::class, static function () {
            return new GroupSettingRepository();
        });
    }

    /**
     * Binds necessary factories.
     */
    private function bindFactories(): void
    {
        $this->app->bind(AggregationFactory::class, static function () {
            return new AggregationFactory();
        });

        $this->app->bind(LogFactory::class, static function () {
            return new LogFactory();
        });

        $this->app->bind(MembershipFactory::class, static function () {
            return new MembershipFactory();
        });

        $this->app->bind(GroupJoinCodeFactory::class, static function () {
            return new GroupJoinCodeFactory();
        });

        $this->app->bind(GroupFactory::class, static function ($app) {
            return new GroupFactory($app->make(GroupRepository::class));
        });

        $this->app->bind(StocktakingDataFactory::class, static function () {
            return new StocktakingDataFactory();
        });

        $this->app->bind(GroupSettingFactory::class, static function () {
            return new GroupSettingFactory();
        });
    }

    /**
     * Binds necessary services.
     */
    private function bindServices(): void
    {
        $this->app->bind(BalanceService::class, static function () {
            return new BalanceService();
        });

        $this->app->bind(JoinGroupService::class, static function ($app) {
            return new JoinGroupService($app->make(MembershipFactory::class));
        });

        $this->app->bind(GroupJoinCodeService::class, static function ($app) {
            return new GroupJoinCodeService($app->make(GroupJoinCodeFactory::class));
        });

        $this->app->bind(CreateGroupService::class, static function ($app) {
            return new CreateGroupService(
                $app->make(GroupFactory::class),
                $app->make(JoinGroupService::class),
                $app->make(GroupJoinCodeService::class)
            );
        });

        $this->app->bind(StocktakingService::class, static function ($app) {
            return new StocktakingService($app->make(StocktakingDataFactory::class));
        });

        $this->app->bind(GroupAdminService::class, static function () {
            return new GroupAdminService();
        });

        $this->app->bind(GroupSettingsService::class, static function ($app) {
            return new GroupSettingsService(
                $app->make(GroupSettingRepository::class),
                $app->make(GroupSettingFactory::class)
            );
        });
    }

    /**
     * Bootstraps any necessary components and component namespaces.
     */
    private function bootstrapComponents(): void
    {
        Blade::componentNamespace('App\\View\\Components\\Log', 'log');
        Blade::componentNamespace('App\\View\\Components\\Overview', 'overview');
    }

    /**
     * Bootstraps all custom blade directives.
     */
    private function bootstrapBladeDirectives(): void
    {
        Blade::directive('trim', function() {
            return '<?php ob_start() ?>';
        });

        Blade::directive('endtrim', function() {
            return '<?php echo trim(ob_get_clean()); ?>';
        });

    }
}
