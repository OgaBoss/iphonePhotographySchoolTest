<?php

namespace App\Modules\Achievement\Actions;

use App\Models\User;

class LessonWatchedCount
{
    /**
     * @param User $user
     * @return int
     */
    public function count(User $user): int
    {
        return $user->lessons()->where('watched', true)->count();
    }
}
