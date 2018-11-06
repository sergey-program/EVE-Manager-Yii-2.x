<?php

namespace app\components\actions;

use app\components\items\Blueprint;
use app\components\items\Item;
use app\components\items\ItemCollection;
use yii\base\Component;

/**
 * Class ActionManufacture
 *
 * @package app\components\actions
 */
class ActionManufacture extends Component
{
    /**
     * @param Blueprint $blueprint
     * @param int       $runs
     *
     * @return ItemCollection
     */
    public function calculate(Blueprint $blueprint, $runs = 1)
    {
        $collection = new ItemCollection();

        foreach ($blueprint->getMaterials() as $material) {
            $me = 1 - ($blueprint->getSettings()->me / 100);
            $meRig = 1 - ($blueprint->getSettings()->meRig / 100);
            $meHull = 1 - ($blueprint->getSettings()->meHull / 100);

            $quantity = ceil($material->getQuantity() * $runs * $me * $meRig * $meHull); // * $this->getRuns();

            $collection->addItem(new Item(['invType' => $material->invType, 'quantity' => $quantity]));
        }

        return $collection;
    }
}