<?php

namespace app\components\items;

use yii\base\BaseObject;

/**
 * Class AbstractItemCollection
 *
 * @package app\components\items
 *
 * @property ItemInterface[]|array $items
 * @property int[]|array           $typeIDs
 */
abstract class AbstractItemCollection extends BaseObject
{
    /** @var AbstractItem[]|array $items */
    private $items = [];

    /**
     * @param Item $item
     *
     * @return $this
     */
    public function addItem(Item $item)
    {
        $this->items[] = clone $item;

        return $this;
    }

    /**
     * Find item in collection and add quantity.
     * If item was not found, add new one.
     *
     * @param Item $item
     *
     * @return $this
     */
    public function addItemQuantity(Item $item)
    {
        if ($this->hasItem($item->typeID)) {
            foreach ($this->getItems() as $cItem) {
                if ($cItem->isTypeID($item->typeID)) {
                    $cItem->addQuantity($item->getQuantity());
                }
            }
        } else {
            $this->items[] = clone $item;
        }

        return $this;
    }

    /**
     * @param int $typeID
     *
     * @return bool
     */
    public function hasItem($typeID)
    {
        if (!empty($this->items)) {
            foreach ($this->getItems() as $item) {
                if ($item->isTypeID($typeID)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return Item[]|array
     */
    public function getItems()
    {
        sort($this->items);

        return $this->items;
    }

    /**
     * @param int $typeID
     *
     * @return AbstractItem|mixed|null
     */
    public function getItem($typeID)
    {
        $result = null;

        foreach ($this->getItems() as $item) {
            if ($item->isTypeID($typeID)) {
                $result = $item;
                break;
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getTypeIDs()
    {
        $result = [];

        foreach ($this->getItems() as $item) {
            $result[] = $item->getTypeID();
        }

        return $result;
    }

    /**
     * @param bool $asc
     *
     * @return $this
     */
    public function sort($asc = true)
    {
        if ($asc) {
            ksort($this->items);
        } else {
            krsort($this->items);
        }

        return $this;
    }

    public function getPriceBuy()
    {
        $result = 0;
        foreach ($this->getItems() as $item) {
            $result += $item->getPriceBuy() * $item->getQuantity();
        }

        return $result;
    }

    public function getPriceSell()
    {
        $result = 0;
        foreach ($this->getItems() as $item) {
            $result += $item->getPriceSell() * $item->getQuantity();
        }

        return $result;
    }
}