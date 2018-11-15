<?php

namespace app\modules\calculators\components;

use app\components\items\Item;
use app\components\items\ItemCollection;
use yii\base\Component;

class MineralComponent extends Component
{
    /** @var ItemCollection|null $collectionMinerals */
    private $collectionMinerals;
    /** @var ItemCollection|null $oresCollection */
    private $collectionOres;
    /** @var MineralAsOre|null $mineralAsOre */
    private $mineralAsOre;

    /**
     *
     */
    public function init()
    {
        $this->mineralAsOre = new MineralAsOre();
        $this->collectionOres = new ItemCollection();

        parent::init();
    }

    /**
     * @return ItemCollection|null
     */
    public function getCollectionMinerals()
    {
        return $this->collectionMinerals;
    }

    /**
     * @param ItemCollection|array $collection
     *
     * @return $this
     */
    public function setCollectionMinerals($collection)
    {
        if (is_array($collection)) {
            $this->collectionMinerals = new ItemCollection();

            foreach ($collection as $item) {
                $this->collectionMinerals->addItem($item);
            }
        } else {
            $this->collectionMinerals = clone $collection;
        }

        return $this;
    }

    /**
     * @return ItemCollection
     */
    public function getCollectionOres()
    {
        return $this->collectionOres;
    }

    /**
     * @param ItemCollection|array $collection
     *
     * @return $this
     */
    public function setCollectionOres($collection)
    {
        if (is_array($collection)) {
            $this->collectionOres = new ItemCollection();

            foreach ($collection as $item) {
                $this->collectionOres->addItem($item);
            }
        } else {
            $this->collectionOres = clone $collection;
        }

        return $this;
    }

    public function calculate()
    {
        $items = $this->collectionMinerals->getItems();
        krsort($items);

        foreach ($items as $mineral) { // each mineral
            $this->calculateMineral($mineral);
        }

        return $this;
    }

    /**
     * @param Item $mineral
     *
     * @return $this
     */
    public function calculateMineral($mineral)
    {
        /** @var Item|null $ore */
        $ore = $this->mineralAsOre->getOreForMineral($mineral->typeID);

        if ($ore) { // primary ore exist calculate minerals
            $runs = $this->calculateByPrimaryOre($mineral, $ore);

            if ($runs) {
                $ore->setQuantity($runs);
                $this->collectionOres->addItemQuantity($ore);
            }
        }

        return $this;
    }

    /**
     * @param $typeID
     *
     * @return float|int
     */
    private function getRequiredMinerals($typeID)
    {
        $required = $this->collectionMinerals->getItem($typeID);
        $weHave = 0;

        if ($required && $required->getQuantity() > 0) {
            foreach ($this->collectionOres->getItems() as $ore) {
                /** @var ItemCollection $reprocessed */
                $reprocessed = \Yii::$app->actionRefine->runOne($ore);

                foreach ($reprocessed->getItems() as $rItem) {
                    if ($rItem->typeID == $typeID) {
                        $weHave += $rItem->getQuantity();
                    }
                }
            }

            return ($required->getQuantity() - $weHave);
        }

        return 0;
    }

    /**
     * Calculate one mineral by one ore.
     *
     * @param Item $mineral
     * @param Item $ore
     *
     * @return float|int
     */
    private function calculateByPrimaryOre(Item $mineral, Item $ore) // calculate regarding base items
    {
        $refineRuns = 0;

        /** @var ItemCollection $reprocessed */
        $reprocessed = \Yii::$app->actionRefine->runOne($ore);                  // reprocess one ore

        foreach ($reprocessed->getItems() as $rItem) {
            if ($rItem->typeID == $mineral->typeID) {                           // found mineral in this ore
                $rMinerals = $this->getRequiredMinerals($mineral->typeID);      // get count of mineral we still needs

                if (($rMinerals > 0) && $rItem->getQuantity()) {

//                    if ($mineral->typeID ==36 && $ore->typeID ==  28421 ){
//                        var_dump($rMinerals);
//                        var_dump($rItem->getQuantity());
//                    }
                    $refineRuns = ceil($rMinerals / $rItem->getQuantity()); //  total we need / after refine = refine runs
                }

                break;
            }
        }

        return $refineRuns;
    }

    public function getOreForMineral(Item $mineral)
    {
        $oreID = $this->mineralAsOre->getOreForMineral($mineral->typeID);

        if ($oreID && $this->getcollectionOres()) {
            foreach ($this->collectionOres->getItems() as $ore) {
                if ($oreID->typeID == $ore->typeID) {
                    return $ore;
                }
            }
        }

        return null;
    }

}