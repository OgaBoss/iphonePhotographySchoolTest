<?php

namespace App\modules\Achievement\Interfaces;

use App\modules\Achievement\Entities\AchievementEntity;

interface IAchievementActions
{
    public function getAchievements(): array;

    public function setAchievements(AchievementEntity $achievement): void;

    public function getPreviousAchievements(int $count): array;

    public function getNextAchievement(int $count): array;

    public function hasUnlockedAchievement(int $count): bool;

    public function generateAchievementName(int $count): string;

    public function saveAchievement(int $count): void;
}
