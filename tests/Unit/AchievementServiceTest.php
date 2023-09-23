<?php

namespace Tests\Unit;

use App\modules\Achievement\Factory\AchievementsFactory;
use App\modules\Achievement\Services\AchievementService;
use App\modules\Achievement\Services\LessonsService;
use App\modules\Helpers\EntityHelperActions;
use Mockery\MockInterface;
use Tests\TestCase;

class AchievementServiceTest extends TestCase
{
    public AchievementService $service;

    public array $array =  [1, 2, 3, 4, 5];

    public function setUp(): void
    {
        parent::setUp();

        config()->set('achievements.achievements', $this->array);

        /** @var AchievementsFactory $factoryMock */
        $factoryMock = $this->mock(AchievementsFactory::class, function(MockInterface $mock) {
            $mock
                ->shouldReceive('create')
                ->andReturn($this->lessonsAchievementMocked($this->array));

            $mock
                ->shouldReceive('insert')
                ->with( $this->lessonsAchievementMocked($this->array), 6)
                ->andReturn($this->lessonsAchievementMocked([1,2,3,4,5,6]));
        });

        /** @var EntityHelperActions $actionMock */
        $actionMock = $this->mock(EntityHelperActions::class, function(MockInterface $mock){
            $mock
                ->shouldReceive('previousAchievements')
                ->with( $this->lessonsAchievementMocked($this->array), 5)
                ->andReturn($this->lessonsAchievementMocked([1,2,3,4,5]));

            $mock
                ->shouldReceive('nextEntityValue')
                ->with( $this->lessonsAchievementMocked($this->array),2)
                ->andReturn(3);

            $mock
                ->shouldReceive('convertEntitiesToArray')
                ->with( $this->lessonsAchievementMocked($this->array))
                ->andReturn($this->array);
        });

        $this->service = new AchievementService($factoryMock, $actionMock);

        $this->service->init();
    }

    /** @test */
    public function can_create_achievements()
    {
        $this->assertCount(5, $this->service->achievements);
    }

    /** @test */
    public function can_retrieve_achievements()
    {
        $this->assertEquals($this->lessonsAchievementMocked($this->array), $this->service->achievements);
    }

    /** @test */
    public function can_update_achievements()
    {
       $lessons =  $this->lessonsAchievementMocked([1,2,3,4,5,6]);

       $this->service->setAchievements(6);

        $this->assertEquals($lessons, $this->service->achievements);
        $this->assertEquals(6, $this->service->achievements[5]->value);
    }

    /** @test */
    public function can_retrieve_previous_achievements()
    {
        $lessons =  $this->lessonsAchievementMocked([1,2,3,4,5]);

        $response = $this->service->getPreviousAchievements(5);

        $this->assertEquals($lessons, $response);
    }

    /** @test */
    public function can_retrieve_next_achievements()
    {
        $response = $this->service->getNextAchievement(2);

        $this->assertEquals(3, $response);
    }

    /** @test */
    public function can_check_when_next_achievement_is_unlocked()
    {
        $response = $this->service->hasUnlockedAchievement(2);

        $this->assertTrue($response);
    }

    /** @test */
    public function calculate_total_achievement()
    {
        $response = $this->service->totalAchievement(5);

        $this->assertEquals(5, $response);
    }
}
