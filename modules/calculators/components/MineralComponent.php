<?php

namespace app\modules\calculators\components;

use app\components\items\Item;
use app\components\items\ItemCollection;
use yii\base\Component;

class MineralComponent extends Component
{
    /** @var ItemCollection|null $mineralsCollection */
    private $mineralsCollection;
    /** @var ItemCollection|null $oresCollection */
    private $oresCollection;
    /** @var MineralAsOre|null $mineralAsOre */
    private $mineralAsOre;

    public function init()
    {
        $this->mineralAsOre = new MineralAsOre();
        $this->oresCollection = new ItemCollection();

        parent::init();
    }

    /**
     * @return ItemCollection|null
     */
    public function getMineralsCollection()
    {
        return $this->mineralsCollection;
    }

    /**
     * @param ItemCollection|array $collection
     *
     * @return $this
     */
    public function setMineralsCollection($collection)
    {
        if (is_array($collection)) {
            $this->mineralsCollection = new ItemCollection();

            foreach ($collection as $item) {
                $this->mineralsCollection->addItem($item);
            }
        } else {
            $this->mineralsCollection = $collection;
        }

        return $this;
    }

    /**
     * @return ItemCollection
     */
    public function getOresCollection()
    {
        return $this->oresCollection;
    }

    public function calculate()
    {
        $items = $this->mineralsCollection->getItems();
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
                $this->oresCollection->addItemQuantity($ore);
            }
        }

        return $this;
    }

    private function getRequiredMinerals($typeID)
    {
        $required = $this->mineralsCollection->getItem($typeID);
        $weHave = 0;

        if ($required && $required->getQuantity() > 0) {
            foreach ($this->oresCollection->getItems() as $ore) {
                foreach ($ore->getReprocessResult(true) as $rItem) {
                    if ($rItem->typeID == $typeID) {
                        $weHave += $rItem->getQuantity() * $ore->getQuantity();
                        var_dump($ore->typeName);
                        var_dump($rItem->getQuantity());
                        var_dump($ore->getQuantity());
                        var_dump($weHave);
                        echo '<br/>';
                    }
                }
            }

            return ($required->getQuantity() - $weHave);
        }

        return 0;
    }

    private function calculateByPrimaryOre(Item $mineral, Item $ore) // calculate regarding base items
    {
        $refineRuns = 0;

        foreach ($ore->getReprocessResult(true) as $rItem) {
            if ($rItem->typeID == $mineral->typeID) {
                $rMinerals = $this->getRequiredMinerals($mineral->typeID);

                if ($rMinerals && $rItem->getQuantity()) {

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

        if ($oreID && $this->getOresCollection()) {
            foreach ($this->oresCollection->getItems() as $ore) {
                if ($oreID->typeID == $ore->typeID) {
                    return $ore;
                }
            }
        }

        return null;
    }

}