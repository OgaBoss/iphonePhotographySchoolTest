<?php

namespace App\modules\Achievement\Listeners;

use App\Events\LessonWatched;
use App\Models\Lesson;
use App\Models\User;
use App\modules\Achievement\Actions\LessonWatchedCount;

class HandleLessonWatched
{
    public LessonWatchedCount $count;

    /**
     * @param LessonWatchedCount $count
     */
    public function __construct(LessonWatchedCount $count)
    {
        $this->count = $count;
    }

    public function handle(LessonWatched $event): void
    {
        // Get watched video account
    }
}
