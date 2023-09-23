<?php

namespace App\modules\Achievement\Actions;

use App\Models\User;

class CommentsWrittenCount
{
    public function count(User $user): int
    {
        return $user->comments()->count();
    }
}
