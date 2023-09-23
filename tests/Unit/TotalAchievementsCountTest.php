<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use App\modules\Achievement\Actions\CommentsWrittenCount;
use App\modules\Achievement\Actions\LessonWatchedCount;
use App\modules\Achievement\Actions\TotalAchievementsCount;
use App\modules\Achievement\Services\AchievementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class TotalAchievementsCountTest extends TestCase
{
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
            )
            ->hasAttached(
                Lesson::factory()->count(1),
                ['watched' => false]
            )->create();

        /** @var LessonWatchedCount $lessonMock */
        $lessonMock = $this->mock(LessonWatchedCount::class, function(MockInterface $mock) use ($user) {
            $mock
                ->shouldReceive('count')
                ->with($user)
                ->andReturn(4);
        });

        /** @var CommentsWrittenCount $commentsMock */
        $commentsMock = $this->mock(CommentsWrittenCount::class, function(MockInterface $mock) use ($user) {
            $mock
                ->shouldReceive('count')
                ->with($user)
                ->andReturn(4);
        });

        /** @var AchievementService $serviceMock */
        $serviceMock = $this->mock(AchievementService::class, function(MockInterface $mock) use ($user) {
            $mock
                ->shouldReceive('totalAchievement')
                ->with(4)
                ->andReturn(4);
        });

        $totalAction = new TotalAchievementsCount($serviceMock, $lessonMock, $commentsMock);

        $this->assertEquals(8, $totalAction->count($user));
    }
}
