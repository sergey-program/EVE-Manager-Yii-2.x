<?php

namespace app\components\eve;

use app\models\dump\InvTypeMaterials;
use yii\helpers\ArrayHelper;

/**
 * Class ItemCollection
 *
 * @package app\components\eve
 */
class ItemCollection
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
     * @return Item[]|array
     */
    public function getItems()
    {
        return $this->items;
    }

//    public function getPrice(){
//        $result = 0;
//
//        foreach ($this->items as $item){
//
//        }
//    }

    /**
     * @return Item[]
     */
    public function getReprocess()
    {
        $itemFactory = new ItemFactory();

        // if typeID is in - item has reprocess value
        $sql = 'SELECT typeID, count(materialTypeID) as hasReprocess FROM invTypeMaterials ';
        $sql .= 'WHERE typeID IN(' . implode(',', ArrayHelper::getColumn($this->items, 'typeID')) . ') GROUP BY typeID';
        $canReprocess = \Yii::$app->db->createCommand($sql)->queryAll();

        $typeQuantity = null; // reprocessable grouped

        foreach ($this->items as $item) {
            if (in_array($item->typeID, ArrayHelper::getColumn($canReprocess, 'typeID'))) { // item is reprocessable
                if (isset($typeQuantity[$item->typeID])) {
                    $typeQuantity[$item->typeID] += $item->quantity;
                } else {
                    $typeQuantity[$item->typeID] = $item->quantity;
                }
            } else { // has no reprocess - raw material
                $itemFactory->addType($item->typeID, $item->quantity);
            }
        }

        /** @var InvTypeMaterials[] $invTypeMaterials */
        $invTypeMaterials = InvTypeMaterials::find()
            ->joinWith(['materialInvType'])
            ->where(['invTypeMaterials.typeID' => array_keys($typeQuantity)])
            ->all();

        foreach ($invTypeMaterials as $invTypeMaterial) {
            $itemFactory->addType($invTypeMaterial->materialTypeID, $invTypeMaterial->quantity * $typeQuantity[$invTypeMaterial->typeID]);
        }

        // @todo return collection
        return $itemFactory->createCollection()->getItems();
    }
}