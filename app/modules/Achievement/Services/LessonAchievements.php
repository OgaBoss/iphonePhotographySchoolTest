<?php

namespace App\modules\Achievement\Services;

use App\modules\Achievement\Factory\LessonAchievementFactory;
use App\modules\Achievement\Interfaces\IAchievementActions;
use App\modules\Helpers\EntityHelperActions;
use App\modules\Shared\Entities\ActionEntity;

class LessonAchievements implements IAchievementActions
{
    /** @var ActionEntity[] $achievements */
    public array $achievements;

    /**
     * @var LessonAchievementFactory
     */
    public LessonAchievementFactory $factory;

    public EntityHelperActions $actions;

    /**
     * @param LessonAchievementFactory $factory
     * @param EntityHelperActions $actions
     */
    public function __construct(LessonAchievementFactory $factory, EntityHelperActions $actions)
    {
        $this->factory = $factory;

        $this->actions = $actions;

        $this->achievements = $this->factory->create(config('achievements.lessons'));
    }

    public function getAchievements(): array
    {
        return $this->achievements;
    }

    public function setAchievements(int $count): void
    {
        $this->achievements = $this->factory->insert($this->achievements, $count);
    }

    public function getPreviousAchievements(int $count): array
    {
        return $this->actions->previousAchievements($this->achievements, $count);
    }

    public function getNextAchievement(int $count): int
    {
        return $this->actions->nextAchievement($this->achievements, $count);
    }

    public function hasUnlockedAchievement(int $count): bool
    {
        $values = $this->actions->convertEntitiesToArray($this->achievements);

        return in_array($count, $values);
    }

    public function generateAchievementName(int $count): string
    {
        if ($count === 1) return 'First Lesson Watched';

        return "$count Lessons Watched";
    }
}
