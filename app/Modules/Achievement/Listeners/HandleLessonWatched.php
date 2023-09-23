<?php

namespace App\Modules\Achievement\Listeners;

use App\Events\LessonWatched;
use App\Modules\Achievement\Actions\LessonWatchedCount;
use App\Modules\Achievement\Actions\TotalAchievementsCount;
use App\Modules\Achievement\Events\AchievementUnlocked;
use App\Modules\Achievement\Services\LessonsService;

class HandleLessonWatched
{
    /** @var LessonWatchedCount $lessonWatchedCount */
    public LessonWatchedCount $lessonWatchedCount;

    /** @var LessonsService  $service*/
    public LessonsService $service;

    /** @var TotalAchievementsCount $totalAchievementsCount */
    public TotalAchievementsCount $totalAchievementsCount;

    /**
     * @param LessonWatchedCount $lessonWatchedCount
     * @param LessonsService $service
     * @param TotalAchievementsCount $totalAchievementsCount
     */
    public function __construct(
        LessonWatchedCount $lessonWatchedCount,
        LessonsService $service,
        TotalAchievementsCount $totalAchievementsCount
    )
    {
        $this->lessonWatchedCount = $lessonWatchedCount;
        $this->service = $service;
        $this->totalAchievementsCount = $totalAchievementsCount;
    }

    /**
     * @param LessonWatched $event
     * @return void
     */
    public function handle(LessonWatched $event): void
    {
        // Get watched video account
        $count = $this->lessonWatchedCount->count($event->user);

        $this->service->init();

        $response = $this->service->hasUnlockedAchievement($count);

        if ($response) {
            // Dispatch Achievement Unlocked Event
            AchievementUnlocked::dispatch($this->service->generateAchievementName($count), $event->user);
        }
    }
}
