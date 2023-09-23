<?php

namespace Tests\Unit;

use App\Events\LessonWatched;
use App\Models\Lesson;
use App\Models\User;
use App\modules\Achievement\Events\AchievementUnlocked;
use App\modules\Achievement\Listeners\HandleLessonWatched;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class HandleLessonWatchedTest extends TestCase
{
    public HandleLessonWatched $lessonWatched;

    public array $array =  [1, 5, 10, 25, 50];
    public function setUp(): void
    {
        parent::setUp();

        config()->set('achievements.achievements', $this->array);

        $this->lessonWatched = app(HandleLessonWatched::class);
    }

    /** @test
     * @throws \Exception
     */
    public function confirm_event_is_dispatched()
    {
        Event::fake();

        $user = User::factory()
            ->hasAttached(
                Lesson::factory()->count(25),
                ['watched' => true]
            )
            ->hasAttached(
                Lesson::factory()->count(1),
                ['watched' => false]
            )->create();

        $lesson = Lesson::factory()->create();

        $event = new LessonWatched($lesson, $user);
        $this->lessonWatched->handle($event);

        Event::assertDispatched(AchievementUnlocked::class);
    }

    /** @test
     * @throws \Exception
     */
    public function confirm_event_is_not_dispatched()
    {
        Event::fake();

        $user = User::factory()
            ->hasAttached(
                Lesson::factory()->count(12),
                ['watched' => true]
            )
            ->hasAttached(
                Lesson::factory()->count(1),
                ['watched' => false]
            )->create();

        $event = new LessonWatched(new Lesson(), $user);
        $this->lessonWatched->handle($event);

        Event::assertNotDispatched(AchievementUnlocked::class);
    }
}
