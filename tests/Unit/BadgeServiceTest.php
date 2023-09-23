<?php

namespace Tests\Unit;

use App\Modules\Badge\Service\BadgeService;
use Tests\TestCase;

class BadgeServiceTest extends TestCase
{

    public array $array = [
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

    public array $updateArray = [
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
        ],
        [
            "value" => 20,
            "title" => "Guru"
        ]
    ];

    public BadgeService $service;


    public function setUp(): void
    {
        parent::setUp();

        config()->set('badges.badges', $this->array);

        $this->service = app(BadgeService::class);
    }

    /** @test */
    public function can_create_badge()
    {
        $this->assertCount(4, $this->service->badges);
    }

    /** @test */
    public function can_retrieve_badges()
    {
        $this->assertEquals($this->badgeMocked($this->array), $this->service->badges);
    }

    /** @test */
    public function can_update_achievements()
    {
        $badges =  $this->badgeMocked($this->updateArray);

        $this->service->setAchievements(["value" => 20, "title" => "Guru"]);

        $this->assertEquals($badges, $this->service->badges);
        $this->assertEquals("Guru", $this->service->badges[4]->title);
    }

    /** @test */
    public function can_retrieve_next_badge()
    {
        $response = $this->service->getNextBadge(4);

        $this->assertEquals(8, $response);
    }

    /** @test */
    public function can_check_when_next_badge_is_unlocked()
    {
        $response = $this->service->hasUnlockedBadge(8);

        $this->assertTrue($response);
    }

    /** @test */
    public function generate_badge_name()
    {
        $response = $this->service->generateBadgeName(10);

        $this->assertEquals('Master', $response);
    }
}
