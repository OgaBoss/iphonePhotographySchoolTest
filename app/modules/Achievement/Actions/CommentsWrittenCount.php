<?php

namespace App\modules\Achievement\Actions;

use App\Models\User;

class CommentsWrittenCount
{
    public function __invoke(User $user): int
    {
        return $user->comments()->count();
    }
}
