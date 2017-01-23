<?php

namespace app\components\eve;

use app\components\eveEsi\MarketOrders;
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
     * List of items for this collection. Filled only by calling $this->calculateReprocess().
     *
     * @var Item[]|array $reprocess
     */
    private $reprocess = [];

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

    /**
     * @return Item[]|array
     */
    public function getReprocess()
    {
        return $this->reprocess;
    }

    /**
     * @return $this
     */
    public function calculateReprocess()
    {
        // can reprocess counter
        $canReprocess = \Yii::$app->db
            ->createCommand('SELECT typeID, count(materialTypeID) as hasReprocess FROM invTypeMaterials WHERE typeID IN(' . implode(',', ArrayHelper::getColumn($this->items, 'typeID')) . ') GROUP BY typeID')
            ->queryAll();


        $rg = null; // reprocessable grouped

        foreach ($this->items as $item) {
            if (in_array($item->typeID, ArrayHelper::getColumn($canReprocess, 'typeID'))) { // if item is reprocessable
                if (isset($rg[$item->typeID])) {
                    $rg[$item->typeID] += $item->quantity;
                } else {
                    $rg[$item->typeID] = $item->quantity;
                }
            } else { // has no reprocess - raw material
                $this->addReprocessItem($item);
            }
        }

        /** @var InvTypeMaterials[] $invTypeMaterials */
        $invTypeMaterials = InvTypeMaterials::find()
            ->joinWith(['materialInvType'])
            ->where(['invTypeMaterials.typeID' => array_keys($rg)])
            ->all();

        foreach ($invTypeMaterials as $invTypeMaterial) {
            $itemMaterial = new Item([
                'typeID' => $invTypeMaterial->materialInvType->typeID,
                'typeName' => $invTypeMaterial->materialInvType->typeName,
                'quantity' => $invTypeMaterial->quantity * $rg[$invTypeMaterial->typeID],
                'groupID' => $invTypeMaterial->materialInvType->groupID
            ]);

            $this->addReprocessItem($itemMaterial);
        }

        return $this;
    }

    /**
     * @param Item $item
     *
     * @return $this
     */
    private function addReprocessItem(Item $item)
    {
        $added = false;

        foreach ($this->reprocess as $key => $reprocessItem) {
            if ($reprocessItem->typeID == $item->typeID) {
                $this->reprocess[$key]->quantity += $item->quantity;
                $added = true;
                break;
            }
        }

        if (!$added) {
            $this->reprocess[] = $item;
        }

        return $this;
    }

    /**
     * Fill in all item by prices sell and buy.
     *
     * @param bool $forReprocess
     *
     * @todo refactor to global price updater
     *
     * @return $this
     */
    public function calculatePrices($forReprocess = false)
    {
        $items = $forReprocess ? $this->reprocess : $this->items;

        foreach ($items as $item) {
            if (!$item->getPriceBuy() || !$item->getPriceSell()) {
                $marketOrders = new MarketOrders();
                $marketOrders->getRows($item->typeID);

                $item
                    ->setPriceSell($marketOrders->getPrice(MarketOrders::ORDER_TYPE_SELL))
                    ->setPriceBuy($marketOrders->getPrice(MarketOrders::ORDER_TYPE_BUY));
            }
        }

        return $this;
    }
}