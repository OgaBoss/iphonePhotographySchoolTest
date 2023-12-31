<?php

namespace Tests\Unit;

use App\Modules\Achievement\Services\AchievementService;
use Tests\TestCase;

class AchievementServiceTest extends TestCase
{
    public AchievementService $service;

    public array $array =  [1, 2, 3, 4, 5];

    public function setUp(): void
    {
        parent::setUp();

        config()->set('app.lessons', $this->array);

        $this->service = app(AchievementService::class);

        $this->service->achievements = $this->lessonsAchievementMocked([1,2,3,4,5]);
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
        $response = $this->service->getPreviousAchievements(5);

        $this->assertEquals([1,2,3,4,5], $response);
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
