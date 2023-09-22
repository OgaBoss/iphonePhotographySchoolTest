<?php

namespace App\modules\Achievement\Entities;

class AchievementEntity
{
    public int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
}
