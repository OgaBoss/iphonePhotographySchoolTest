<?php

namespace Tests\Unit;

use App\modules\Achievement\Entities\AchievementEntity;
use PHPUnit\Framework\TestCase;

class AchievementEntityTest extends TestCase
{
    /** @test  */
    public function assert_that_entity_hold_the_correct_value()
    {
        $entityDto = new AchievementEntity(1);

        $this->assertEquals(1, $entityDto->value);
    }
}
