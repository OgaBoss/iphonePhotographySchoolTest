<?php

namespace App\Providers;

use App\modules\Achievement\Interfaces\IAchievementActions;
use App\modules\Achievement\Services\AchievementService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IAchievementActions::class, AchievementService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
