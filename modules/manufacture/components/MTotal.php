<?php

namespace app\modules\manufacture\components;

/**
 * Class MTotal
 *
 * @package app\modules\manufacture\components
 */
class MTotal
{
    /** @var array|MItem $mItems */
    private $mItems = [];

    /**
     * MTotal constructor.
     *
     * @param MItem $mItem // not bpo
     * @param int   $quantity
     */
    public function __construct(MItem $mItem, $quantity = 1)
    {
        if ($mItem->hasBlueprint()) {
            foreach ($mItem->getBlueprint()->getItems() as $item) {
                $this->mergeTotal(MManager::calculateTotal($item, $item->getQuantity() * $quantity));
            }
        } else {
            $this->addItem($mItem->getInvType()->typeID, $quantity);
        }
    }

    /**
     * @param MTotal $mTotal
     */
    public function mergeTotal(MTotal $mTotal)
    {
        foreach ($mTotal->getItems() as $typeID => $mItem) {
            $this->addItem($typeID, $mItem->getQuantity());
        }
    }

    /**
     * @param int $typeID
     * @param int $quantity
     *
     * @return $this
     */
    public function addItem($typeID, $quantity = 1)
    {
        if (isset($this->mItems[$typeID])) {
            $this->mItems[$typeID]->addQuantity($quantity);
        } else {
            $this->mItems[$typeID] = MManager::createItem($typeID, $quantity);
        }

        return $this;
    }

    /**
     * @return array|MItem[]
     */
    public function getItems()
    {
        return $this->mItems;
    }

    /**
     * @return float|int
     */
    public function getPriceSellTotal()
    {
        $result = 0;

        foreach ($this->getItems() as $mItem) {
            $result += $mItem->getPriceSellTotal();
        }

        return $result;
    }

    /**
     * @return float|int
     */
    public function getPriceBuyTotal()
    {
        $result = 0;

        foreach ($this->getItems() as $mItem) {
            $result += $mItem->getPriceBuyTotal();
        }

        return $result;
    }
}