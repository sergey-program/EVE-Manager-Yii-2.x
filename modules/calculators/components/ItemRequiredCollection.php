<?php

namespace app\modules\calculators\components;

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
    public function getObjects()
    {
        return parent::getObjects();
    }

    /**
     * If object in collection, just add quantity. Otherwise add to collection.
     *
     * @param AbstractItem|ItemRequired $item
     *
     * @return $this|AbstractItemCollection
     */
    public function addObject(AbstractItem $item)
    {
        /** @var ItemRequired|null $foundObject */
        $foundObject = null;

        foreach ($this->getObjects() as $object) {
            if ($object->isTypeID($item->getTypeID())) {
                $foundObject = $object;
                break;
            }
        }

        if ($foundObject) {
            $foundObject->addQuantity($item->getQuantity());
        } else {
            parent::addObject($item);
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
    public function addObjectArray($invType, $quantity = 1)
    {
        $this->addObject(new ItemRequired([
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
        foreach ($this->getObjects() as $object) {
            if ($object->isTypeID($typeID)) {
                return $object->getQuantity();
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
        foreach ($this->getObjects() as $object) {
            if ($object->isTypeID($typeID)) {
                return $object->getQuantityWeHave();
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
        foreach ($this->getObjects() as $object) {
            if ($object->isTypeID($typeID)) {
                $object->addQuantityWeHave($quantity);
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

    public function parseTotal(MTotal $mTotal)
    {
        if ($mTotal->getItems()) {
            foreach ($mTotal->getItems() as $typeID => $mItem) {
                $this->addObjectArray($mItem->getInvType(), $mItem->getQuantity());
            }
        }

        return $this;
    }
}