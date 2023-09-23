<?php

namespace App\modules\Achievement\Actions;

use App\Models\User;
use App\modules\Achievement\Services\AchievementService;
use App\modules\Achievement\Services\CommentsService;
use App\modules\Achievement\Services\LessonsService;

class TotalAchievementsCount
{
    public CommentsService $commentsService;

    public LessonsService $lessonsService;

    public LessonWatchedCount $watchedCount;

    public CommentsWrittenCount $writtenCount;
    /**
     * @param CommentsService $commentsService
     * @param LessonsService $lessonsService
     * @param LessonWatchedCount $watchedCount
     * @param CommentsWrittenCount $writtenCount
     * */
    public function __construct(
     CommentsService $commentsService,
     LessonsService $lessonsService,
     LessonWatchedCount $watchedCount,
     CommentsWrittenCount $writtenCount)
{
    $this->commentsService = $commentsService;
    $this->lessonsService = $lessonsService;
    $this->watchedCount = $watchedCount;
    $this->writtenCount = $writtenCount;

    $this->commentsService->init();
    $this->lessonsService->init();
}

    public function count(User $user): int
    {
        $lessonCounts = $this->lessonsService->totalAchievement($this->watchedCount->count($user));
        $commentsCounts = $this->commentsService->totalAchievement($this->writtenCount->count($user));

       return $lessonCounts + $commentsCounts;
    }
}
