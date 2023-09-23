<?php

namespace App\Modules\Badge\Factory;

use App\Modules\Shared\Entities\ActionEntity;

class BadgeFactory
{
    /**
     * @param array $badgeValues
     * @return ActionEntity[]
     */
    public function create(array $badgeValues): array
    {
        $badges = [];

        foreach ($badgeValues as $value) {
            $badges[] = new ActionEntity($value['value'], $value['title']);
        }

        /** @var ActionEntity[] */
        return $badges;
    }

    /**
     * @param ActionEntity[] $badges
     * @param array $newBadge
     * @return ActionEntity[]
     */
    public function insert(array $badges, array $newBadge): array
    {
        $badge = new ActionEntity($newBadge['value'], $newBadge['title']);

        if ($badges[0]->value > $newBadge['value']) {
            array_splice($badges, 0, 0, $badge);
            return $badges;
        }

        if ($badges[count($badges) - 1]->value < $newBadge['value']) {
            array_splice($badges, count($badges), 0, [$badge]);
            return $badges;
        }

        foreach ($badges as $key => $entity) {
            if ($entity->value > $newBadge['value'] &&  $badges[$key + 1] < $newBadge['value']) {
                array_splice($badges, $key, 0, [$badge]);
                return $badges;
            }
        }

        return $badges;
    }
}
