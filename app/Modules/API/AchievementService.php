<?php

namespace App\Modules\API;

use App\Models\User;
use App\Modules\Achievement\Actions\TotalAchievementsCount;
use App\Modules\Achievement\Services\CommentsService;
use App\Modules\Achievement\Services\LessonsService;
use App\Modules\Badge\Service\BadgeService;

class AchievementService
{
    /**
     * @var User
     */
    public User $user;
    /**
     * @var TotalAchievementsCount
     */
    public TotalAchievementsCount $totalCount;
    /**
     * @var CommentsService
     */
    public CommentsService $commentsService;
    /**
     * @var LessonsService
     */
    public LessonsService $lessonsService;
    /**
     * @var BadgeService
     */
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

    /**
     * @return array
     */
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

    /**
     * @return array
     */
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

    /**
     * @return array
     */
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

    /**
     * @return int
     */
    public function getRemainderToNextBadge(): int
    {
        return $this->badgeService->getNextBadge($this->getAchievementCount()) - $this->getAchievementCount();
    }

    /**
     * @return string
     */
    public function getNextBadge(): string
    {
        $response = $this->badgeService->getNextBadge($this->getAchievementCount());

        if ($response === -1) return  '';

        return $this->badgeService->generateBadgeName($response);
    }

    /**
     * @return string
     */
    public function getCurrentBadge(): string
    {
        $response = $this->badgeService->getCurrentBadge($this->getAchievementCount());

        if ($response === -1) return '';

        return $this->badgeService->generateBadgeName($response);
    }

    /**
     * @return int
     */
    public function getNextAvailableCommentAchievement(): int
    {
        return $this
            ->commentsService
            ->getNextAchievement($this->totalCount->totalCommentAchievementCount($this->user));
    }

    /**
     * @return int
     */
    public function getNextAvailableLessonAchievement(): int
    {
        return $this
            ->lessonsService
            ->getNextAchievement($this->totalCount->totalLessonsAchievementCount($this->user));
    }

    /**
     * @return array
     */
    public function getUnlockedCommentAchievements(): array
    {
        return $this
            ->commentsService
            ->getPreviousAchievements($this->totalCount->totalCommentAchievementCount($this->user));
    }

    /**
     * @return array
     */
    public function getUnlockedLessonsAchievements(): array
    {
        return $this
            ->lessonsService
            ->getPreviousAchievements($this->totalCount->totalLessonsAchievementCount($this->user));
    }

    /**
     * @return int
     */
    public function getAchievementCount(): int
    {
        return $this->totalCount->count($this->user);
    }

    /**
     * @param int $value
     * @return string
     */
    private function generateCommentAchievementName(int $value): string
    {
        return $this->commentsService->generateAchievementName($value);
    }

    /**
     * @param int $value
     * @return string
     */
    private function generateLessonsAchievementName(int $value): string
    {
        return $this->lessonsService->generateAchievementName($value);
    }

}
