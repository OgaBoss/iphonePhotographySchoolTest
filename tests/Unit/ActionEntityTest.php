<?php

namespace Tests\Unit;

use App\Modules\Shared\Entities\ActionEntity;
use Tests\TestCase;

class ActionEntityTest extends TestCase
{
    /** @test  */
    public function assert_that_entity_hold_the_correct_value()
    {
        $entityDto = new ActionEntity(1);

        $this->assertEquals(1, $entityDto->value);
    }
}
