<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AchievementControllerTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        config()->set('achievements.lessons', [1, 5, 10, 25, 50]);
        config()->set('achievements.comments', [1, 3, 5, 10, 20]);
    }

    /** @test */
    public function achievement_api_response_assertions_scenario_a()
    {
        $user = User::factory()
            ->has(
                Comment::factory()->count(4)
            )
            ->hasAttached(
                Lesson::factory()->count(6),
                ['watched' => true]
            )->create();


        $response = $this->getJson("/users/{$user->id}/achievements");

        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
            $json->where('unlocked_achievements', ['First Lesson Watched', '5 Lessons Watched', 'First Comment Written', '3 Comments Written'])
                ->where('next_available_achievements', ['10 Lessons Watched', '5 Comments Written'])
                ->where('current_badge', 'Intermediate')
                ->where('next_badge', 'Advanced')
                ->where('remaining_to_unlock_next_badge', 4)
                ->etc()
        );
    }

    /** @test */
    public function achievement_api_response_assertions_scenario_b()
    {
        $user = User::factory()
            ->has(
                Comment::factory()->count(4)
            )
            ->hasAttached(
                Lesson::factory()->count(4),
                ['watched' => true]
            )->create();


        $response = $this->getJson("/users/{$user->id}/achievements");

        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
        $json->where('unlocked_achievements', ['First Lesson Watched','First Comment Written', '3 Comments Written'])
            ->where('next_available_achievements', ['5 Lessons Watched', '5 Comments Written'])
            ->where('current_badge', 'Beginner')
            ->where('next_badge', 'Intermediate')
            ->where('remaining_to_unlock_next_badge', 1)
            ->etc()
        );
    }

    /** @test */
    public function achievement_api_response_assertions_scenario_c()
    {
        $user = User::factory()
            ->has(
                Comment::factory()->count(100)
            )
            ->hasAttached(
                Lesson::factory()->count(100),
                ['watched' => true]
            )->create();


        $response = $this->getJson("/users/{$user->id}/achievements");

        ray($response);

        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
        $json->where('unlocked_achievements', [
            "First Lesson Watched",
            "5 Lessons Watched",
            "10 Lessons Watched",
            "25 Lessons Watched",
            "50 Lessons Watched",
            "First Comment Written",
            "3 Comments Written",
            "5 Comments Written",
            "10 Comments Written",
            "20 Comments Written"
        ])
            ->where('next_available_achievements', [])
            ->where('current_badge', 'Master')
            ->where('next_badge', '')
            ->where('remaining_to_unlock_next_badge', 0)
            ->etc()
        );
    }
}
