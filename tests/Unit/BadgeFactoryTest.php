<?php

namespace Tests\Unit;

use App\Modules\Badge\Factory\BadgeFactory;
use Tests\TestCase;

class BadgeFactoryTest extends TestCase
{
    /** @test */
    public function should_be_able_to_create_entities_from_array()
    {

        $array = [
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

        $factory = new BadgeFactory();

        $badges = $factory->create($array);

        $this->assertCount(4, $badges);

        $this->assertEquals(0, $badges[0]->value);
        $this->assertEquals('Beginner', $badges[0]->title);
    }

    /** @test */
    public function should_be_able_to_add_more_achievement()
    {
        $badges = [
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

        $badge = [
            "value" => 20,
            "title" => "Guru"
        ];

        $factory = new BadgeFactory();

        $newBadges = $factory->insert($factory->create($badges), $badge);

        $this->assertCount(5, $newBadges);
        $this->assertEquals("Guru", $newBadges[4]->title);
    }
}
