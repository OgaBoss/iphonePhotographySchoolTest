<?php

namespace Tests;

use App\modules\Achievement\Factory\AchievementsFactory;
use App\modules\Badge\Factory\BadgeFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function lessonsAchievementMocked(array $values): array
    {
        $factory = new AchievementsFactory();

        return $factory->create($values);
    }

    public function badgeMocked(array $values): array
    {
        $factory = new BadgeFactory();

        return $factory->create($values);
    }
}
