<?php

namespace App\modules\Achievement\Services;

use App\modules\Achievement\Factory\AchievementsFactory;
use App\modules\Achievement\Interfaces\IAchievementActions;
use App\modules\Helpers\EntityHelperActions;
use App\modules\Shared\Entities\ActionEntity;

class AchievementService implements IAchievementActions
{
    /** @var ActionEntity[] $achievements */
    public array $achievements;

    /**
     * @var AchievementsFactory
     */
    public AchievementsFactory $factory;

    /**
     * @var EntityHelperActions
     */
    public EntityHelperActions $actions;

    /**
     * @param AchievementsFactory $factory
     * @param EntityHelperActions $actions
     */
    public function __construct(AchievementsFactory $factory, EntityHelperActions $actions)
    {
        $this->factory = $factory;

        $this->actions = $actions;
    }

    public function init(): void
    {
        $this->achievements = $this->factory->create(config('achievements.achievements'));
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
        return $this->actions->nextEntityValue($this->achievements, $count);
    }

    public function hasUnlockedAchievement(int $count): bool
    {
        $values = $this->actions->convertEntitiesToArray($this->achievements);

        return in_array($count, $values);
    }

    public function totalAchievement(int $count): int
    {
        $values = $this->getPreviousAchievements($count);

        return count($values);
    }
}
