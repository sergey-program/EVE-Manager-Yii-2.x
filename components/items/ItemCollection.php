<?php

namespace app\components\items;
/**
 * Class ItemCollection
 *
 * @package app\components\items
 *
 * @property int $priceBuy
 * @property int $priceSell
 *
 * @todo    relocate this class
 */
class ItemCollection extends AbstractItemCollection
{
    /**
     * @return float|int
     */
    public function getPriceBuy()
    {
        $result = 0;

        foreach ($this->getItems() as $item) {
            $result += $item->getPriceBuy() * $item->getQuantity();
        }

        return $result;
    }

    /**
     * @return float|int
     */
    public function getPriceSell()
    {
        $result = 0;

        foreach ($this->getItems() as $item) {
            $result += $item->getPriceSell() * $item->getQuantity();
        }

        return $result;
    }
}
