<?php

namespace App\modules\Achievement\Actions;

use App\Models\User;

class LessonWatchedCount
{
    public function __invoke(User $user): int
    {
        return $user->lessons()->where('watched', true)->count();
    }
}
