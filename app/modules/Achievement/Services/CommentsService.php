<?php

namespace App\modules\Achievement\Services;

class CommentsService extends AchievementService
{
    public function generateAchievementName(int $count): string
    {
        if ($count === 1) return 'First Comment Written';

        return "$count Comments Written";
    }
}
