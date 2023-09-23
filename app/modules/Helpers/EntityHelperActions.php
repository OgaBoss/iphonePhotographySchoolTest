<?php

namespace App\modules\Helpers;

use App\modules\Shared\Entities\ActionEntity;

class EntityHelperActions
{
    /**
     * @param ActionEntity[] $achievements
     * @param int $count
     * @return int[]
     */
    public function previousAchievements(array $achievements, int $count): array
    {
        $values = $this->convertEntitiesToArray($achievements);

        $possibleAchievement = $count;

        if (!in_array($count, $values)){
            $possibleAchievement = $this->checkForPossibleAchievement($values, $count);
        };

        $index = array_search($possibleAchievement, $values);
        if(!$index) return [];

        return array_slice($values, 0, $index + 1);
    }


    /**
     * @param array $achievements
     * @param int $count
     * @return int
     */
    public function nextAchievement(array $achievements, int $count): int
    {
        $values = $this->convertEntitiesToArray($achievements);
        if ($values[count($values) -  1] === $count) return -1;

        $possibleAchievement = $count;
        $countInValues = true;

        if (!in_array($count, $values)){
            $countInValues = false;
            $possibleAchievement = $this->checkForPossibleAchievement($values, $count);
        };

        if ($possibleAchievement < 0) return $possibleAchievement;

        $index = array_search($possibleAchievement, $values);

        $index = $countInValues ? $index + 1 : $index;
        return $values[$index];
    }

    /**
     * @param ActionEntity[] $achievements
     * @return int[]
     */
    public function convertEntitiesToArray(array $achievements): array
    {
        $values = [];

        foreach ($achievements as $achievement) {
            $values[] = $achievement->value;
        }

        return $values;
    }

    /**
     * @param array $achievements
     * @param int $count
     * @return int
     */
    private function checkForPossibleAchievement(array $achievements, int $count): int
    {
        if ($achievements[0] > $count) return $achievements[0];

        $possibleAchievement = -1;

        foreach ($achievements as $key => $achievement) {
            if ($achievement > $count) {
                $possibleAchievement = $achievements[$key - 1];
            }
        }

        return $possibleAchievement;
    }

}
