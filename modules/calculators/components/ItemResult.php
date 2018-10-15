<?php

namespace app\modules\calculators\components;

/**
 * Class ItemResult
 *
 * @package app\modules\calculators\components
 */
class ItemResult extends AbstractItem
{
    /** @var ItemResult[]|array ItemResult[] */
    private $items = [];

    /**
     * @param ItemResult $itemResult
     *
     * @return $this
     */
    public function addItems(ItemResult $itemResult)
    {
        if (isset($this->items[$itemResult->typeID])) {
            $this->items[$itemResult->typeID]->addQuantity($itemResult->getQuantity());
        } else {
            $this->items[$itemResult->typeID] = $itemResult;
        }

        return $this;
    }

    /**
     * @return ItemResult[]|array
     */
    public function getItems()
    {
        return $this->items;
    }
}