<?php

namespace App\Modules\Achievement\Factory;

use App\Modules\Shared\Entities\ActionEntity;

class AchievementsFactory
{
    /**
     * @param array $achievementValues
     * @return ActionEntity[]
     */
    public function create(array $achievementValues): array
    {
        $achievements = [];

        foreach ($achievementValues as $value) {
            $achievements[] = new ActionEntity($value);
        }

        /** @var ActionEntity[] */
        return $achievements;
    }

    /**
     * @param ActionEntity[] $achievements
     * @param int $count
     * @return ActionEntity[]
     */
    public function insert(array $achievements, int $count): array
    {
        $achievement = new ActionEntity($count);

        if ($achievements[0]->value > $count) {
            array_splice($achievements, 0, 0, $achievement);
            return $achievements;
        }

        if ($achievements[count($achievements) - 1]->value < $count) {
             array_splice($achievements, count($achievements), 0, [$achievement]);
             return $achievements;
        }

        foreach ($achievements as $key => $entity) {
            $keyToCheck = $key === count($achievements) - 1 ? $key : $key + 1;

            if ($entity->value > $count && $keyToCheck < $count) {
                array_splice($achievements, $key, 0, [$achievement]);
                return $achievements;
            }
        }

        return $achievements;
    }
}
