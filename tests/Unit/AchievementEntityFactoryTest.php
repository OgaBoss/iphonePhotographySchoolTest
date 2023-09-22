<?php

namespace Tests\Unit;

use App\modules\Achievement\Entities\AchievementEntities;
use App\modules\Achievement\Factory\AchievementEntityFactory;
use PHPUnit\Framework\TestCase;

class AchievementEntityFactoryTest extends TestCase
{
    /** @test */
    public function should_be_able_to_create_entities_from_array()
    {

        $array = [1,2,3,4,5];

        $factory = new AchievementEntityFactory();

        $achievements = new AchievementEntities($factory($array));

        $this->assertCount(5, $achievements->achievements);

        $this->assertEquals(1, $achievements->achievements[0]->value);
    }
}
