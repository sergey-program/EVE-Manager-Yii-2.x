<?php

namespace app\components\actions;

use app\components\items\Blueprint;
use app\components\items\BlueprintCollection;
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
     * Return materials required for blueprint.
     *
     * @param Blueprint $blueprint
     *
     * @return ItemCollection
     */
    public function calculate(Blueprint $blueprint)
    {
        $collection = new ItemCollection();

        if ($blueprint->getMaterials()) {
            foreach ($blueprint->getMaterials() as $material) {
                $me = 1 - ($blueprint->getSettings()->me / 100);
                $meRig = 1 - ($blueprint->getSettings()->meRig / 100);
                $meHull = 1 - ($blueprint->getSettings()->meHull / 100);
                $quantity = ceil($material->getQuantity() * $me * $meRig * $meHull); // * $this->getRuns();
                $collection->addItemQuantity(new Item(['invType' => $material->invType, 'quantity' => $quantity]));
            }
        }
        return $collection;
    }

    /**
     * Return minerals (raw materials that cannot be manufactured).
     *
     * @param Blueprint $blueprint
     *
     * @return ItemCollection
     */
    public function calculateMinerals(Blueprint $blueprint)
    {
        $result = new ItemCollection();
        $collection = $this->calculate($blueprint);

        foreach ($collection->getItems() as $item) {
            if ($item->hasBlueprint()) {
                $collectionInner = $this->calculateMinerals($item->getBlueprint());

                foreach ($collectionInner->getItems() as $itemInner) {
                    $result->addItemQuantity($itemInner);
                }
            } else {
                $result->addItemQuantity($item);
            }
        }

        return $result;
    }

    /**
     * Return all used blueprints by main blueprint.
     *
     * @param Blueprint $blueprint
     *
     * @return BlueprintCollection
     */
    public function getAllBlueprints(Blueprint $blueprint)
    {
        $result = new BlueprintCollection();
        $result->addItem($blueprint);

        $collection = $this->calculate($blueprint);

        foreach ($collection->getItems() as $item) {
            if ($item->hasBlueprint()) {
                $collectionInner = $this->getAllBlueprints($item->getBlueprint());

                foreach ($collectionInner->getItems() as $itemInner) {
                    $result->addItem($itemInner);
                }
            }
        }

        return $result;
    }
}