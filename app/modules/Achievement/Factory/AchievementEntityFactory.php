<?php

namespace App\modules\Achievement\Factory;

use App\modules\Achievement\Entities\AchievementEntity;

class AchievementEntityFactory
{
    public function __invoke(array $achievementValues): array
    {
        $achievements = [];

        foreach ($achievementValues as $value) {
            $achievements[] = new AchievementEntity($value);
        }

        /** @var AchievementEntity[] */
        return $achievements;
    }
}
