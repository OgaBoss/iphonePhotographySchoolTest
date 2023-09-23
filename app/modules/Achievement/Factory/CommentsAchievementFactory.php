<?php

namespace App\modules\Achievement\Factory;

use App\modules\Shared\Entities\ActionEntity;

class CommentsAchievementFactory
{
    /**
     * @param array $achievementValues
     * @return ActionEntity[]
     */
    public function create(array $achievementValues): array
    {
        $achievements = [];

        /** @var [int $value, string $title] $value */
        foreach ($achievementValues as $value) {
            $achievements[] = new ActionEntity($value->value, $value->title);
        }

        /** @var ActionEntity[] */
        return $achievements;
    }
}
