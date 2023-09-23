<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use App\Modules\API\AchievementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiAchievementServiceTest extends TestCase
{
    use RefreshDatabase;

    public AchievementService $service;

    public User $user;

    public function setUp(): void
    {
        parent::setUp();

        config()->set('app.lessons', [1, 5, 10, 25, 50]);
        config()->set('app.comments', [1, 3, 5, 10, 20]);

        $this->user = User::factory()
            ->has(Comment::factory()->count(4))
            ->hasAttached(
                Lesson::factory()->count(6),
                ['watched' => true]
            )->create();

        $this->service = app(AchievementService::class);

        $this->service->user = $this->user;
    }


    /** @test */
    public function get_total_achievements()
    {
        $response = $this->service->getAchievementCount();

        $this->assertEquals(4, $response);
    }

    /** @test */
    public function get_unlocked_lesson_achievements()
    {
        $response = $this->service->getUnlockedLessonsAchievements();

        $this->assertCount(2, $response);
    }

    /** @test */
    public function get_unlocked_comments_achievements()
    {
        $response = $this->service->getUnlockedCommentAchievements();

        $this->assertCount(2, $response);
    }

    /** @test */
    public function get_next_available_lesson_achievement()
    {
        $response = $this->service->getNextAvailableLessonAchievement();

        $this->assertEquals(10, $response);
    }

    /** @test */
    public function get_next_available_comment_achievement()
    {
        $response = $this->service->getNextAvailableCommentAchievement();

        $this->assertEquals(5, $response);
    }

    /** @test */
    public function get_current_badge()
    {
        $response = $this->service->getCurrentBadge();

        $this->assertEquals('Intermediate', $response);
    }

    /** @test */
    public function get_next_badge()
    {
        $response = $this->service->getNextBadge();

        $this->assertEquals('Advanced', $response);
    }

    /** @test */
    public function get_remainder_to_next_badge()
    {
        $response = $this->service->getRemainderToNextBadge();

        $this->assertEquals(4, $response);
    }

    /** @test */
    public function handle_unlocked_achievement()
    {
        $response = $this->service->handleUnlockedAchievement();

        $this->assertEquals(['First Lesson Watched', '5 Lessons Watched', 'First Comment Written', '3 Comments Written'], $response);
    }

    /** @test */
    public function handle_next_available_achievement()
    {
        $response = $this->service->handleNextAvailableAchievement();

        $this->assertEquals(['10 Lessons Watched', '5 Comments Written'], $response);
    }

    /** @test */
    public function handle_execute_api_response()
    {
        $response = $this->service->execute();

        $actual = [
            'unlocked_achievements'             => ['First Lesson Watched', '5 Lessons Watched', 'First Comment Written', '3 Comments Written'],
            'next_available_achievements'       => ['10 Lessons Watched', '5 Comments Written'],
            'current_badge'                     => 'Intermediate',
            'next_badge'                        => 'Advanced',
            'remaining_to_unlock_next_badge'    => 4
        ];

        $this->assertEquals($actual, $response);
    }

}
