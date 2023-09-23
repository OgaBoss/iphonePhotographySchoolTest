<?php

namespace App\Modules\Badge\Service;

use App\Modules\Badge\Factory\BadgeFactory;
use App\Modules\Helpers\EntityHelperActions;
use App\Modules\Shared\Entities\ActionEntity;

class BadgeService
{
    /** @var ActionEntity[] $badges */
    public array $badges;

    /**
     * @var EntityHelperActions
     */
    public EntityHelperActions $actions;

    public BadgeFactory $factory;

    /**
     * @param EntityHelperActions $actions
     * @param BadgeFactory $factory
     */
    public function __construct(BadgeFactory $factory, EntityHelperActions $actions)
    {
        $this->actions = $actions;

        $this->factory = $factory;

        $this->badges = $this->factory->create(config('badges.badges'));
    }

    public function getAchievements(): array
    {
        return $this->badges;
    }

    public function setAchievements(array $newBadge): void
    {
        $this->badges = $this->factory->insert($this->badges, $newBadge);
    }

    public function hasUnlockedBadge(int $count): bool
    {
        $values = $this->actions->convertEntitiesToArray($this->badges);

        return in_array($count, $values);
    }

    public function getNextBadge(int $count): int
    {
        return $this->actions->nextEntityValue($this->badges, $count);
    }

    public function getCurrentBadge(int $count): int
    {
        return $this->actions->currentEntityValue($this->badges, $count);
    }

    public function generateBadgeName(int $count): string
    {
        foreach ($this->badges as $badge) {
            if ($badge->value === $count) {
                return $badge->title;
            }
        }

        return '';
    }
}
