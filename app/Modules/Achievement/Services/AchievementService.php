<?php

namespace App\Modules\Achievement\Services;

use App\Modules\Achievement\Factory\AchievementsFactory;
use App\Modules\Achievement\Interfaces\IAchievementActions;
use App\Modules\Helpers\EntityHelperActions;
use App\Modules\Shared\Entities\ActionEntity;

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

    /**
     * @return ActionEntity[]
     */
    public function getAchievements(): array
    {
        return $this->achievements;
    }

    /**
     * @param int $count
     * @return void
     */
    public function setAchievements(int $count): void
    {
        $this->achievements = $this->factory->insert($this->achievements, $count);
    }

    /**
     * @param int $count
     * @return array
     */
    public function getPreviousAchievements(int $count): array
    {
        return $this->actions->previousAchievements($this->achievements, $count);
    }

    /**
     * @param int $count
     * @return int
     */
    public function getNextAchievement(int $count): int
    {
        return $this->actions->nextEntityValue($this->achievements, $count);
    }

    /**
     * @param int $count
     * @return bool
     */
    public function hasUnlockedAchievement(int $count): bool
    {
        $values = $this->actions->convertEntitiesToArray($this->achievements);

        return in_array($count, $values);
    }

    /**
     * @param int $count
     * @return int
     */
    public function totalAchievement(int $count): int
    {
        $values = $this->getPreviousAchievements($count);

        return count($values);
    }
}
