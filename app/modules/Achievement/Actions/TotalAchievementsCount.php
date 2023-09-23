<?php

namespace App\modules\Achievement\Actions;

use App\Models\User;
use App\modules\Achievement\Services\AchievementService;

class TotalAchievementsCount
{
    public AchievementService $service;

    public LessonWatchedCount $watchedCount;

    public CommentsWrittenCount $writtenCount;

    /**
     * @param AchievementService $service
     * @param LessonWatchedCount $watchedCount
     * @param CommentsWrittenCount $writtenCount
     */
    public function __construct(
        AchievementService $service,
        LessonWatchedCount $watchedCount,
        CommentsWrittenCount $writtenCount
    )
    {
        $this->service = $service;
        $this->watchedCount = $watchedCount;
        $this->writtenCount = $writtenCount;
    }


    public function count(User $user): int
    {
        $lessonCounts = $this->service->totalAchievement($this->watchedCount->count($user));
        $commentsCounts = $this->service->totalAchievement($this->writtenCount->count($user));

        return $lessonCounts + $commentsCounts;
    }
}
