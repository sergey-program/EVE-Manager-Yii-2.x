<?php

namespace app\components\actions;

use app\components\items\Item;
use app\components\items\ItemCollection;
use app\models\dump\InvTypeMaterials;
use yii\base\Component;

/**
 * Class ActionRefine
 *
 * @package app\components\actions
 */
class ActionRefine extends Component
{
    /** @var int $percent */
    public $percent = 84;

    /**
     * Return materials that will be retrieved after refine (base quantity).
     *
     * @param Item $item
     *
     * @return InvTypeMaterials[]|array
     */
    public function getResult(Item $item)
    {
        return InvTypeMaterials::find()->where(['typeID' => $item->typeID])->cache(60 * 60 * 24)->all();
    }

    /**
     * @param Item $item
     * @param bool $rup // Return UnProcessable items
     *
     * @return ItemCollection
     */
    public function runOne(Item $item, $rup = false)
    {
        $refineResult = $this->getResult($item);
        $result = new ItemCollection();

        if ($refineResult) {
            foreach ($refineResult as $invTypeMaterial) {
                $quantity = $invTypeMaterial->quantity * $item->getQuantity();
                $quantity = ceil($quantity * ($this->percent / 100));

                $material = new Item(['invType' => $invTypeMaterial->materialInvType, 'quantity' => $quantity]);
                $result->addItemQuantity($material);
            }
        } else {
            if ($rup) {
                $result->addItemQuantity($item);
            }
        }

        return $result;
    }

    /**
     * @param ItemCollection $collection
     * @param bool           $rup // Return UnProcessable items
     *
     * @return ItemCollection
     */
    public function runCollection(ItemCollection $collection, $rup = false)
    {
        $result = new ItemCollection();

        foreach ($collection->getItems() as $item) {
            foreach ($this->runOne($item, $rup)->getItems() as $rItem) {
                $result->addItemQuantity($rItem);
            }
        }

        return $result;

    }
}