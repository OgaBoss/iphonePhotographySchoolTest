<?php

namespace App\modules\Achievement\Listeners;

use App\Events\LessonWatched;
use App\modules\Achievement\Actions\LessonWatchedCount;
use App\modules\Achievement\Events\AchievementUnlocked;
use App\modules\Achievement\Services\LessonsService;
use App\modules\Badge\Events\BadgeUnlocked;

class HandleLessonWatched
{
    public LessonWatchedCount $lessonWatchedCount;

    public LessonsService $service;

    /**
     * @param LessonWatchedCount $lessonWatchedCount
     * @param LessonsService $service
     */
    public function __construct(LessonWatchedCount $lessonWatchedCount, LessonsService $service)
    {
        $this->lessonWatchedCount = $lessonWatchedCount;
        $this->service = $service;
    }

    public function handle(LessonWatched $event): void
    {
        // Get watched video account
        $count = $this->lessonWatchedCount->count($event->user);

        $this->service->init();

        $response = $this->service->hasUnlockedAchievement($count);

        if ($response) {
            // Dispatch Achievement Unlocked Event
            AchievementUnlocked::dispatch($this->service->generateAchievementName($count));

            // Dispatch Badge Event
//            BadgeUnlocked::dispatch()
        }
    }
}
