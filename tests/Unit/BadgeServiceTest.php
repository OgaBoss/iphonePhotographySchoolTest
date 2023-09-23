<?php

namespace Tests\Unit;

use App\Modules\Badge\Factory\BadgeFactory;
use App\Modules\Badge\Service\BadgeService;
use App\Modules\Helpers\EntityHelperActions;
use Mockery\MockInterface;
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

        /** @var BadgeFactory $factoryMock */
        $factoryMock = $this->mock(BadgeFactory::class, function(MockInterface $mock) {
            $mock
                ->shouldReceive('create')
                ->andReturn($this->badgeMocked($this->array));


            $mock
                ->shouldReceive('insert')
                ->with( $this->badgeMocked($this->array), ["value" => 20, "title" => "Guru"])
                ->andReturn($this->badgeMocked($this->updateArray));
        });

        /** @var EntityHelperActions $actionMock */
        $actionMock = $this->mock(EntityHelperActions::class, function(MockInterface $mock){
            $mock
                ->shouldReceive('currentEntityValue')
                ->with( $this->badgeMocked($this->array), 4)
                ->andReturn(4);

            $mock
                ->shouldReceive('nextEntityValue')
                ->with( $this->badgeMocked($this->array), 4)
                ->andReturn(8);

            $mock
                ->shouldReceive('convertEntitiesToArray')
                ->with( $this->badgeMocked($this->array))
                ->andReturn([0,4,8,10]);
        });

        $this->service = new BadgeService($factoryMock, $actionMock);
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
