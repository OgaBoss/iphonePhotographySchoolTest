<?php

namespace App\Modules\Achievement\Services;

class CommentsService extends AchievementService
{
    public function init(): void
    {
        $this->achievements = $this->factory->create(config('achievements.comments'));
    }

    public function generateAchievementName(int $count): string
    {
        if ($count === 1) return 'First Comment Written';

        return "$count Comments Written";
    }
}
