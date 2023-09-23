<?php

namespace Tests\Unit;

use App\Models\Lesson;
use App\Models\User;
use App\Modules\Achievement\Actions\LessonWatchedCount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonWatchedCountTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function get_the_count_of_lesson_user_watched(): void
    {
        $user = User::factory()
            ->hasAttached(
                Lesson::factory()->count(4),
                ['watched' => true]
            )
            ->hasAttached(
                Lesson::factory()->count(1),
                ['watched' => false]
            )->create();

        $count = new LessonWatchedCount();

        $this->assertEquals(4, $count->count($user));
    }
}
