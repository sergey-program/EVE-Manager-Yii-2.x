<?php

namespace app\components\eve;

use app\models\dump\InvTypeMaterials;
use yii\helpers\ArrayHelper;

/**
 * Class ActionReprocess
 *
 * @package app\components\eve
 */
class ActionReprocess
{
    /**
     * @param ItemCollection $itemCollection
     * @param int            $percent
     *
     * @return ItemCollection
     */
    public static function run(ItemCollection $itemCollection, $percent = 100)
    {
        $percent = ($percent / 100);
        $itemFactory = new ItemFactory();
        $items = $itemCollection->getItems();

        // if typeID is in - item has reprocess items
        $sql = 'SELECT typeID, count(materialTypeID) as hasReprocess FROM invTypeMaterials ';
        $sql .= 'WHERE typeID IN(' . implode(',', ArrayHelper::getColumn($items, 'typeID')) . ') GROUP BY typeID';

        $canReprocess = \Yii::$app->db->createCommand($sql)->queryAll();

        $typeQuantity = null; // reprocessable grouped

        foreach ($items as $item) {
            if (in_array($item->typeID, ArrayHelper::getColumn($canReprocess, 'typeID'))) { // item is reprocessable
                if (isset($typeQuantity[$item->typeID])) {
                    $typeQuantity[$item->typeID] += $item->quantity;
                } else {
                    $typeQuantity[$item->typeID] = $item->quantity;
                }
            } else { // has no reprocess - raw material
                $itemFactory->addType($item->typeID, round($item->quantity * $percent));
            }
        }

        /** @var InvTypeMaterials[] $invTypeMaterials */
        $invTypeMaterials = InvTypeMaterials::find()
            ->joinWith(['materialInvType'])
            ->where(['invTypeMaterials.typeID' => array_keys($typeQuantity)])
            ->all();

        foreach ($invTypeMaterials as $invTypeMaterial) {
            $itemFactory->addType(
                $invTypeMaterial->materialTypeID,
                round($invTypeMaterial->quantity * $typeQuantity[$invTypeMaterial->typeID] * $percent)
            );
        }

        return new ItemCollection(['items' => $itemFactory->loadItems()->getItems()]);
    }
}
