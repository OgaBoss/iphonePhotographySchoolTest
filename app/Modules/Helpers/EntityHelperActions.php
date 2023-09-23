<?php

namespace App\Modules\Helpers;

use App\Modules\Shared\Entities\ActionEntity;

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
        if ($values[count($values) -  1] <= $count) return $values;

        $possibleAchievement = $count;

        if (!in_array($count, $values)){
            $possibleAchievement = $this->checkForPossibleAchievement($values, $count);
        }

        $index = array_search($possibleAchievement, $values);
        if($index === false) return [];

        return array_slice($values, 0, $index + 1);
    }


    /**
     * @param ActionEntity[] $achievements
     * @param int $count
     * @return int
     */
    public function nextEntityValue(array $achievements, int $count): int
    {
        $values = $this->convertEntitiesToArray($achievements);
        if ($values[count($values) -  1] <= $count) return -1;

        $possibleAchievement = $count;

        if (!in_array($count, $values)){
            $possibleAchievement = $this->checkForPossibleAchievement($values, $count);
        }

        if ($possibleAchievement < 0) return -1;

        $index = array_search($possibleAchievement, $values);

        return $values[$index + 1];
    }

    /**
     * @param ActionEntity[] $achievements
     * @param int $count
     * @return int
     */
    public function currentEntityValue(array $achievements, int $count): int
    {
        $values = $this->convertEntitiesToArray($achievements);

        $possibleAchievement = $count;

        if (!in_array($count, $values)){
            $possibleAchievement = $this->checkForPossibleAchievement($values, $count);
        }

        if ($possibleAchievement < 0) return -1;

        $index = array_search($possibleAchievement, $values);

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
                break;
            }
        }

        return $possibleAchievement;
    }

}
