<?php

namespace App\Modules\Achievement\Services;

class LessonsService extends AchievementService
{
    public function init(): void
    {
        $this->achievements = $this->factory->create(config('app.lessons'));
    }

    /**
     * @param int $count
     * @return string
     */
    public function generateAchievementName(int $count): string
    {
        if ($count === 1) return 'First Lesson Watched';

        return "$count Lessons Watched";
    }
}
