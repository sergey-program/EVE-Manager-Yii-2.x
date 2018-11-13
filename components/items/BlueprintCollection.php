<?php

namespace app\components\items;
/**
 * Class BlueprintCollection
 *
 * @package app\components\items
 */
class BlueprintCollection extends AbstractItemCollection
{
    /**
     * @return int
     */
    public function getRunPrices()
    {
        $result = 0;

        foreach ($this->getItems() as $item) {
            $result += $item->getSettings()->runPrice * $item->getRuns();
        }

        return $result;
    }
}