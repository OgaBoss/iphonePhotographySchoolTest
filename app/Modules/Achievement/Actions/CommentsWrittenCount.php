<?php

namespace App\Modules\Achievement\Actions;

use App\Models\User;

class CommentsWrittenCount
{
    /**
     * @param User $user
     * @return int
     */
    public function count(User $user): int
    {
        return $user->comments()->count();
    }
}
