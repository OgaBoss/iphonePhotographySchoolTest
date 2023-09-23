<?php

namespace App\modules\Achievement\Services;

class LessonsService extends AchievementService
{
    public function init(): void
    {
        $this->achievements = $this->factory->create(config('achievements.lessons'));
    }

    public function generateAchievementName(int $count): string
    {
        if ($count === 1) return 'First Lesson Watched';

        return "$count Lessons Watched";
    }
}
