<?php

namespace Tests\Unit;

use App\modules\Achievement\Factory\AchievementsFactory;
use PHPUnit\Framework\TestCase;

class AchievementsFactoryTest extends TestCase
{
    /** @test */
    public function should_be_able_to_create_entities_from_array()
    {

        $array = [1,2,3,4,5];

        $factory = new AchievementsFactory();

        $achievements = $factory->create($array);

        $this->assertCount(5, $achievements);

        $this->assertEquals(1, $achievements[0]->value);
    }

    /** @test */
    public function should_be_able_to_add_more_achievement()
    {
        $array = [1,2,3,4,5];

        $factory = new AchievementsFactory();

        $achievements = $factory->insert($factory->create($array), 6);

        $this->assertCount(6, $achievements);
    }

    /** @test */
    public function should_be_able_to_add_more_achievement_in_order()
    {
        $array = [1,2,3,4,6];

        $factory = new AchievementsFactory();

        $achievements = $factory->insert($factory->create($array), 5);

        $this->assertCount(6, $achievements);
        $this->assertEquals(5, $achievements[4]->value);
    }
}
