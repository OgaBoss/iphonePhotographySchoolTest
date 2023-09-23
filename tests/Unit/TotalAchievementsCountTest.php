<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use App\Modules\Achievement\Actions\TotalAchievementsCount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TotalAchievementsCountTest extends TestCase
{
    public TotalAchievementsCount $totalAchievementsCount;

    use RefreshDatabase;
    /** @test */
    public function can_get_total_Achievement_count()
    {
        $user = User::factory()
            ->has(
                Comment::factory()->count(4)
            )
            ->hasAttached(
                Lesson::factory()->count(4),
                ['watched' => true]
            )->create();

        config()->set('app.lessons', [1, 5, 10, 25, 50]);
        config()->set('app.comments', [1, 3, 5, 10, 20]);

        $this->totalAchievementsCount = app(TotalAchievementsCount::class);

        $this->assertEquals(3, $this->totalAchievementsCount->count($user));
    }
}
