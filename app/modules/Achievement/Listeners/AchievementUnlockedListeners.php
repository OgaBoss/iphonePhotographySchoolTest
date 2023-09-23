<?php

namespace App\modules\Achievement\Listeners;

use App\modules\Achievement\Actions\TotalAchievementsCount;
use App\modules\Achievement\Events\AchievementUnlocked;
use App\modules\Badge\Events\BadgeUnlocked;
use App\modules\Badge\Service\BadgeService;

class AchievementUnlockedListeners
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
