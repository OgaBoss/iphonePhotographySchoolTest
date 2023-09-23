<?php

namespace Tests\Unit;

use App\Events\CommentWritten;
use App\Models\Comment;
use App\Models\User;
use App\Modules\Achievement\Events\AchievementUnlocked;
use App\Modules\Achievement\Listeners\HandleCommentWritten;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class HandleCommentWrittenTest extends TestCase
{
    public HandleCommentWritten $commentWritten;

    public array $array =  [1, 3, 5, 10, 20];
    public function setUp(): void
    {
        parent::setUp();

        config()->set('achievements.lessons', [1, 5, 10, 25, 50]);
        config()->set('achievements.comments', [1, 3, 5, 10, 20]);

        $this->commentWritten = app(HandleCommentWritten::class);
    }

    /** @test
     * @throws \Exception
     */
    public function confirm_event_is_dispatched(): void
    {
        Event::fake();

        $user = User::factory()->has(Comment::factory()->count(9))->create();

        $comment = Comment::factory()->for($user)->create();

        $event = new CommentWritten($comment);
        $this->commentWritten->handle($event);

        Event::assertDispatched(AchievementUnlocked::class);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function confirm_event_is_not_dispatched(): void
    {
        Event::fake();

        $user = User::factory()->has(Comment::factory()->count(8))->create();

        $comment = Comment::factory()->for($user)->create();

        $event = new CommentWritten($comment);
        $this->commentWritten->handle($event);

        Event::assertNotDispatched(AchievementUnlocked::class);
    }
}
