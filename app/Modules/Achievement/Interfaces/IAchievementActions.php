<?php

namespace App\Modules\Achievement\Interfaces;

interface IAchievementActions
{
    public function getAchievements(): array;

    public function setAchievements(int $count): void;

    public function getPreviousAchievements(int $count): array;

    public function getNextAchievement(int $count): int;

    public function hasUnlockedAchievement(int $count): bool;

    public function totalAchievement(int $count): int;
}
