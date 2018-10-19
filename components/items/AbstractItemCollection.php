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
     * @param AbstractItem $item
     *
     * @return $this
     */
    public function addItem(AbstractItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @return AbstractItem[]|array
     */
    public function getItems()
    {
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
}