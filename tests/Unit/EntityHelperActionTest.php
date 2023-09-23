<?php

namespace Tests\Unit;

use App\modules\Achievement\Factory\LessonAchievementFactory;
use App\modules\Helpers\EntityHelperActions;
use Tests\TestCase;

class EntityHelperActionTest extends TestCase
{
    /** @test */
    public function should_be_able_to_fetch_previous_achievements()
    {
        $array = [1, 2, 5, 10, 12];

        $factory = new LessonAchievementFactory();

        $helper = new EntityHelperActions();

        $achievements = $helper->previousAchievements($factory->create($array), 10);

        $this->assertCount(4, $achievements);
    }

    /** @test */
    public function should_be_able_to_fetch_previous_achievements_when_achievement_is_not_unlocked()
    {
        $array = [1, 2, 5, 10, 12];

        $factory = new LessonAchievementFactory();

        $helper = new EntityHelperActions();

        $achievements = $helper->previousAchievements($factory->create($array), 11);

        $this->assertCount(4, $achievements);
    }


    /** @test */
    public function should_be_able_to_fetch_next_achievements()
    {
        $array = [1,2,5,10,12];

        $factory = new LessonAchievementFactory();

        $helper = new EntityHelperActions();

        $achievements = $helper->nextAchievement($factory->create($array), 10);

        $this->assertEquals(12, $achievements);
    }

    /** @test */
    public function should_be_able_to_fetch_next_achievements_when_achievement_is_not_unlocked()
    {
        $array = [1, 2, 5, 10, 12];

        $factory = new LessonAchievementFactory();

        $helper = new EntityHelperActions();

        $achievements = $helper->nextAchievement($factory->create($array), 6);

        $this->assertEquals(10, $achievements);
    }

    /** @test */
    public function should_return_negative_if_value_is_last_achievement()
    {
        $array = [1,2,5,10,12];

        $factory = new LessonAchievementFactory();

        $helper = new EntityHelperActions();

        $achievements = $helper->nextAchievement($factory->create($array), 12);

        $this->assertEquals(-1, $achievements);
    }
}
