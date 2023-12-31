<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use App\Modules\Achievement\Events\AchievementUnlocked;
use App\Modules\Achievement\Listeners\HandleAchievementUnlocked;
use App\Modules\Badge\Events\BadgeUnlocked;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class HandleAchievementUnlockedTest extends TestCase
{
    use RefreshDatabase;
    public HandleAchievementUnlocked $achievementUnlocked;

    public array $badges =  [
        [
            "value" => 0,
            "title" => "Beginner"
        ],
        [
            "value" => 4,
            "title" => "Intermediate"
        ],
        [
            "value" => 8,
            "title" => "Advanced"
        ],
        [
            "value" => 10,
            "title" => "Master"
        ]
    ];
    public function setUp(): void
    {
        parent::setUp();

        config()->set('app.badges', $this->badges);
        config()->set('app.lessons', [1, 5, 10, 25, 50]);
        config()->set('app.comments', [1, 3, 5, 10, 20]);

        $this->achievementUnlocked = app(HandleAchievementUnlocked::class);
    }

    /** @test
     * @throws \Exception
     */
    public function confirm_event_is_dispatched(): void
    {
        Event::fake();

        $user = User::factory()
            ->has(Comment::factory()->count(1))
            ->hasAttached(
                Lesson::factory()->count(10),
                ['watched' => true]
            )->create();

        Comment::factory()->for($user)->create();

        $event = new AchievementUnlocked('First Comment Written', $user);
        $this->achievementUnlocked->handle($event);

        Event::assertDispatched(BadgeUnlocked::class);
    }

    /** @test
     * @throws \Exception
     */
    public function confirm_event_is_not_dispatched(): void
    {
        Event::fake();

        $user = User::factory()
            ->hasAttached(
                Lesson::factory()->count(10),
                ['watched' => true]
            )->create();

        Comment::factory()->count(6)->for($user)->create();

        $event = new AchievementUnlocked('First Comment Written', $user);
        $this->achievementUnlocked->handle($event);

        Event::assertNotDispatched(BadgeUnlocked::class);
    }
}
