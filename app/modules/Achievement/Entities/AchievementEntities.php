<?php

namespace App\modules\Achievement\Entities;

class AchievementEntities
{
    public array $achievements;

    /**
     * @param AchievementEntity[] $value
     */
    public function __construct(array $value) {
        $this->achievements = $value;
    }
}
