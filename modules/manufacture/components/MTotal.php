<?php

namespace app\modules\manufacture\components;

use app\models\MarketPrice;

/**
 * Class MTotal
 *
 * @package app\modules\manufacture\components
 */
class MTotal
{
    /** @var array $items */
    private $items = [];

    /**
     * MTotal constructor.
     *
     * @param MItem $mItem
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
        foreach ($mTotal->getItems() as $typeID => $item) {
            $this->addItem($typeID, $item['quantity']);
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
        if (isset($this->items[$typeID])) {
            $this->items[$typeID]['quantity'] += $quantity;
        } else {
            $this->items[$typeID]['quantity'] = $quantity;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    public function loadPrices()
    {
        $typeIDs = array_keys($this->getItems());

        $prices = MarketPrice::find()->where(['typeID' => $typeIDs])->cache(60)->all();

        foreach ($prices as $price) {
            $this->items[$price->typeID]['price'] = $price;
        }

        return $this;
    }
}