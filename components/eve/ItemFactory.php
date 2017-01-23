<?php

namespace app\components\eve;

use app\models\dump\InvTypes;
use yii\helpers\ArrayHelper;

/**
 * Class ItemFactory
 *
 * Create new Item classes by typeName or\and typeID array.
 *
 * @package app\components\eve
 */
class ItemFactory
{
    /**
     * Created Item objects. After $this->loadItems() they should be totally filled in.
     *
     * @var Item[]|array $items
     */
    private $items = [];

    /**
     * $typeString can be typeID or typeName.
     *
     * @param string|int $typeString
     * @param int        $quantity
     *
     * @return $this
     */
    public function addType($typeString, $quantity = 1)
    {
        $added = false;

        // try to add only quantity if such type is in
        foreach ($this->items as $key => $item) {
            if ($item->typeID == $typeString || $item->typeName == $typeString) {
                $this->items[$key]->quantity += $quantity;
                $added = true;
                break;
            }
        }

        // create new item
        if (!$added) {
            $item = new Item(['quantity' => $quantity]);

            if (is_numeric($typeString)) {
                $item->setTypeID($typeString);
            } else {
                $item->setTypeName($typeString);
            }

            $this->items[] = $item;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function createCollection()
    {
        /** @var InvTypes[] $invTypes */
        $invTypes = InvTypes::find()
            ->orFilterWhere(['invTypes.typeName' => ArrayHelper::getColumn($this->items, 'typeName')])
            ->orFilterWhere(['invTypes.typeID' => ArrayHelper::getColumn($this->items, 'typeID')])
            ->joinWith('marketPrice')
            ->all();


        foreach ($invTypes as $invType) {
            foreach ($this->items as $key => $item) {
                if ($item->getTypeName() && $item->getTypeName() == $invType->typeName) {
                    $this->items[$key]
                        ->setTypeID($invType->typeID)
                        ->setPriceSell($invType->marketPrice ? $invType->marketPrice->sell : 0)
                        ->setPriceBuy($invType->marketPrice ? $invType->marketPrice->buy : 0)
                        ->setGroupID($invType->groupID);
                }

                if ($item->getTypeID() && $item->getTypeID() == $invType->typeID) {
                    $this->items[$key]
                        ->setTypeName($invType->typeName)
                        ->setPriceSell($invType->marketPrice ? $invType->marketPrice->sell : 0)
                        ->setPriceBuy($invType->marketPrice ? $invType->marketPrice->buy : 0)
                        ->setGroupID($invType->groupID);
                }
            }
        }

        return $this;
    }

    /**
     * @return Item[]
     */
    public function getItems()
    {
        return $this->items;
    }
}