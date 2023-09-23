<?php

namespace App\Modules\Achievement\Listeners;

use App\Events\CommentWritten;
use App\Modules\Achievement\Actions\CommentsWrittenCount;
use App\Modules\Achievement\Actions\TotalAchievementsCount;
use App\Modules\Achievement\Events\AchievementUnlocked;
use App\Modules\Achievement\Services\CommentsService;

class HandleCommentWritten
{
    public CommentsWrittenCount $writtenCount;

    public CommentsService $service;

    public TotalAchievementsCount $totalAchievementsCount;

    /**
     * @param CommentsWrittenCount $writtenCount
     * @param CommentsService $service
     * @param TotalAchievementsCount $totalAchievementsCount
     */
    public function __construct(
        CommentsWrittenCount $writtenCount,
        CommentsService $service,
        TotalAchievementsCount $totalAchievementsCount)
    {
        $this->writtenCount = $writtenCount;
        $this->service = $service;
        $this->totalAchievementsCount = $totalAchievementsCount;
    }


    public function handle(CommentWritten $event): void
    {
        // Get watched video account
        $count = $this->writtenCount->count($event->comment->user);

        $this->service->init();

        $response = $this->service->hasUnlockedAchievement($count);

        if ($response) {
            // Dispatch Achievement Unlocked Event
            AchievementUnlocked::dispatch($this->service->generateAchievementName($count), $event->comment->user);
        }
    }
}
