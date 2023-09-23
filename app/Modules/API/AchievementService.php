<?php

namespace App\Modules\API;

use App\Models\User;
use App\Modules\Achievement\Actions\TotalAchievementsCount;
use App\Modules\Achievement\Services\CommentsService;
use App\Modules\Achievement\Services\LessonsService;
use App\Modules\Badge\Service\BadgeService;

class AchievementService
{
    public User $user;

    public TotalAchievementsCount $totalCount;

    public CommentsService $commentsService;

    public LessonsService $lessonsService;

    public BadgeService $badgeService;

    /**
     * @param TotalAchievementsCount $totalCount
     * @param CommentsService $commentsService
     * @param LessonsService $lessonsService
     * @param BadgeService $badgeService
     */
    public function __construct(
        TotalAchievementsCount $totalCount,
        CommentsService $commentsService,
        LessonsService $lessonsService,
        BadgeService $badgeService
    )
    {
        $this->totalCount = $totalCount;
        $this->commentsService = $commentsService;
        $this->lessonsService = $lessonsService;
        $this->badgeService = $badgeService;

        $this->commentsService->init();
        $this->lessonsService->init();
    }


    public function execute(): array
    {
        return [
            'unlocked_achievements'             => $this->handleUnlockedAchievement(),
            'next_available_achievements'       => $this->handleNextAvailableAchievement(),
            'current_badge'                     => $this->getCurrentBadge(),
            'next_badge'                        => $this->getNextBadge(),
            'remaining_to_unlock_next_badge'    => max($this->getRemainderToNextBadge(), 0)
        ];
    }

    public function handleUnlockedAchievement(): array
    {
        $lessons = $this->getUnlockedLessonsAchievements();
        $comments = $this->getUnlockedCommentAchievements();

        $names = [];

        foreach ($lessons as $lesson) {
            $names[] = $this->generateLessonsAchievementName($lesson);
        }

        foreach ($comments as $comment) {
            $names[] = $this->generateCommentAchievementName($comment);
        }

        return $names;
    }

    public function handleNextAvailableAchievement(): array
    {
        $lessons = $this->getNextAvailableLessonAchievement();
        $comments = $this->getNextAvailableCommentAchievement();

        $names = [];

        if ($lessons >= 0) {
            $names[] = $this->generateLessonsAchievementName($lessons);
        }

        if ($comments >= 0) {
            $names[] = $this->generateCommentAchievementName($comments);
        }


        return $names;
    }

    public function getRemainderToNextBadge(): int
    {
        return $this->badgeService->getNextBadge($this->getAchievementCount())- $this->getAchievementCount();
    }

    public function getNextBadge(): string
    {
        $response = $this->badgeService->getNextBadge($this->getAchievementCount());

        ray($response);

        if ($response === -1) return  '';

        return $this->badgeService->generateBadgeName($response);
    }

    public function getCurrentBadge(): string
    {
        $response = $this->badgeService->getCurrentBadge($this->getAchievementCount());

        if ($response === -1) return '';

        return $this->badgeService->generateBadgeName($response);
    }

    public function getNextAvailableCommentAchievement(): int
    {
        return $this
            ->commentsService
            ->getNextAchievement($this->totalCount->totalCommentAchievementCount($this->user));
    }

    public function getNextAvailableLessonAchievement(): int
    {
        return $this
            ->lessonsService
            ->getNextAchievement($this->totalCount->totalLessonsAchievementCount($this->user));
    }

    public function getUnlockedCommentAchievements(): array
    {
        return $this
            ->commentsService
            ->getPreviousAchievements($this->totalCount->totalCommentAchievementCount($this->user));
    }

    public function getUnlockedLessonsAchievements(): array
    {
        return $this
            ->lessonsService
            ->getPreviousAchievements($this->totalCount->totalLessonsAchievementCount($this->user));
    }

    public function getAchievementCount(): int
    {
        return $this->totalCount->count($this->user);
    }

    private function generateCommentAchievementName(int $value): string
    {
        return $this->commentsService->generateAchievementName($value);
    }

    private function generateLessonsAchievementName(int $value): string
    {
        return $this->lessonsService->generateAchievementName($value);
    }

}
