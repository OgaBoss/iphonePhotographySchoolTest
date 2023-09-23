<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\User;
use App\Modules\Achievement\Actions\CommentsWrittenCount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentsWrittenCountTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function get_the_count_of_lesson_user_watched(): void
    {
        $user = User::factory()
            ->has(
                Comment::factory()->count(4)
            )->create();

        $count = new CommentsWrittenCount();

        $this->assertEquals(4, $count->count($user));
    }
}
