<?php

namespace App\Modules\Achievement\Services;

use Illuminate\Support\Facades\Config;

class CommentsService extends AchievementService
{
    public function init(): void
    {
        $this->achievements = $this->factory->create(Config::get('app.comments'));
    }

    public function generateAchievementName(int $count): string
    {
        if ($count === 1) return 'First Comment Written';

        return "$count Comments Written";
    }
}
