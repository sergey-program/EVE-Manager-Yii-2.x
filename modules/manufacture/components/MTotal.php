<?php

namespace app\modules\manufacture\components;

class MTotal
{
    private $items = [];

    public function __construct(MItem $mItem, $quantity = 1)
    {
        if ($mItem->hasBlueprint()) {
            foreach ($mItem->getBlueprint()->getItems() as $mItemMerge) {
                $total = MManager::calculateTotal($mItemMerge, $mItemMerge->getQuantity());
                $this->mergeTotal($total);
            }
        } else {
            $this->addItem($mItem->getInvType()->typeID, $mItem->getQuantity() * $quantity);
        }
    }

    public function mergeTotal(MTotal $mTotal)
    {
        foreach ($mTotal->getItems() as $typeID => $quantity) {
            $this->addItem($typeID, $quantity);
        }
    }

    public function addItem($typeID, $quantity = 1)
    {
        if (isset($this->items[$typeID])) {
            $this->items[$typeID] += $quantity;
        } else {
            $this->items[$typeID] = $quantity;
        }

        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }
}