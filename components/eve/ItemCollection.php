<?php

namespace app\components\eve;

use yii\base\Object;

/**
 * Class ItemCollection
 *
 * @package app\components\eve
 */
class ItemCollection extends Object
{
    /**
     * Items that is used. Simple ArrayCollection pattern.
     *
     * @var Item[]|array $items
     */
    private $items = [];

    /**
     * @param Item $item
     *
     * @return $this
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param Item[]|array $items
     *
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return Item[]|array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param bool $isBuy
     *
     * @return int|float
     */
    public function getPrice($isBuy = true)
    {
        $result = 0;

        foreach ($this->items as $item) {
            if ($isBuy) {
                $result += $item->getPriceBuy();
            } else {
                $result += $item->getPriceSell();
            }
        }

        return $result;
    }
}