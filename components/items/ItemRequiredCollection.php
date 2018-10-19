<?php

namespace app\components\items;

use app\models\dump\InvTypes;
use app\modules\manufacture\components\MTotal;

/**
 * Class ItemRequiredCollection
 *
 * @package app\modules\calculators\components
 */
class ItemRequiredCollection extends AbstractItemCollection
{
    /**
     * @return AbstractItem[]|ItemRequired[]|array
     */
    public function getItems()
    {
        return parent::getItems();
    }

    /**
     * If item in collection, just add quantity. Otherwise add to collection.
     *
     * @param AbstractItem|ItemRequired $item
     *
     * @return $this|AbstractItemCollection
     */
    public function addItem(AbstractItem $item)
    {
        /** @var ItemRequired|null $foundItem */
        $foundItem = null;

        foreach ($this->getItems() as $object) {
            if ($object->isTypeID($item->getTypeID())) {
                $foundItem = $object;
                break;
            }
        }

        if ($foundItem) {
            $foundItem->addQuantity($item->getQuantity());
        } else {
            parent::addItem($item);
        }

        return $this;
    }

    /**
     * Add to collection using simple parameters.
     *
     * @param InvTypes $invType
     * @param int      $quantity
     *
     * @return $this
     */
    public function addItemArray($invType, $quantity = 1) // @todo refactor method name
    {
        $this->addItem(new ItemRequired([
            'invType' => $invType,
            'quantity' => $quantity
        ]));

        return $this;
    }

    /**
     * Return quantity for typeID from collection.
     *
     * @param int $typeID
     *
     * @return int
     */
    public function getQuantity($typeID)
    {
        foreach ($this->getItems() as $item) {
            if ($item->isTypeID($typeID)) {
                return $item->getQuantity();
            }
        }

        return 0;
    }

    /**
     * Return quantityWeHave for typeID from collection.
     *
     * @param int $typeID
     *
     * @return int
     */
    public function getQuantityWeHave($typeID)
    {
        foreach ($this->getItems() as $item) {
            if ($item->isTypeID($typeID)) {
                return $item->getQuantityWeHave();
            }
        }

        return 0;
    }

    /**
     * Add quantityWeHave for typeID in collection.
     *
     * @param int $typeID
     * @param int $quantity
     *
     * @return $this
     */
    public function addQuantityWeHave($typeID, $quantity = 1)
    {
        foreach ($this->getItems() as $item) {
            if ($item->isTypeID($typeID)) {
                $item->addQuantityWeHave($quantity);
            }
        }

        return $this;
    }

    /**
     * Count quantity minus quantityWeHave for typeID from collection.
     *
     * @param int  $typeID
     * @param bool $ceil
     *
     * @return float|int
     */
    public function getQuantityTotal($typeID, $ceil = true)
    {
        $result = $this->getQuantity($typeID) - $this->getQuantityWeHave($typeID);

        return $ceil ? ceil($result) : $result;
    }

    /**
     * @param MTotal $mTotal
     *
     * @return $this
     */
    public function parseTotal(MTotal $mTotal)
    {
        if ($mTotal->getItems()) {
            foreach ($mTotal->getItems() as $typeID => $mItem) {
                $this->addItemArray($mItem->getInvType(), $mItem->getQuantity());
            }
        }

        return $this;
    }
}