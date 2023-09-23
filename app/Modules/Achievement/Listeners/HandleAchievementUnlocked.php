<?php

namespace App\Modules\Achievement\Listeners;

use App\Modules\Achievement\Actions\TotalAchievementsCount;
use App\Modules\Achievement\Events\AchievementUnlocked;
use App\Modules\Badge\Events\BadgeUnlocked;
use App\Modules\Badge\Service\BadgeService;

class HandleAchievementUnlocked
{
    public TotalAchievementsCount $totalAchievementsCount;

    public BadgeService $service;

    /**
     * @param TotalAchievementsCount $totalAchievementsCount
     * @param BadgeService $service
     */
    public function __construct(TotalAchievementsCount $totalAchievementsCount, BadgeService $service)
    {
        $this->totalAchievementsCount = $totalAchievementsCount;
        $this->service = $service;
    }

    public function handle(AchievementUnlocked $event): void
    {
        $total = $this->totalAchievementsCount->count($event->user);

        $response = $this->service->hasUnlockedBadge($total);

        if ($response) {
            BadgeUnlocked::dispatch($this->service->generateBadgeName($total), $event->user);
        }
    }
}
