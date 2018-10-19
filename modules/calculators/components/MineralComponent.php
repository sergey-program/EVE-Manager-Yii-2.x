<?php

namespace app\modules\calculators\components;

use app\components\items\ItemRequiredCollection;
use app\components\items\ItemResult;
use app\models\CompressSettings;
use app\models\dump\InvTypeMaterials;
use app\models\dump\InvTypes;
use yii\base\Component;

class MineralComponent extends Component
{
    /** @var ItemRequiredCollection */
    private $itemRequiredCollection;
    /** @var array|null $primaryOre */
    public $primaryOre;

    public function init()
    {
        foreach ([40, 39, 38, 37, 36, 35, 34] as $mineralTypeID) { // defaults
            $this->primaryOre[$mineralTypeID] = null;
        }

        $cSettings = CompressSettings::findAll(['userID' => \Yii::$app->user->id]);

        foreach ($cSettings as $setting) {
            $this->primaryOre[$setting->mineralTypeID] = $setting->oreTypeID;
        }

        parent::init();
    }

    /** @var ItemResult[] $result */
    public $result = [];

    /**
     * @param ItemRequiredCollection $irc
     *
     * @return $this
     */
    public function setItemRequiredCollection(ItemRequiredCollection $irc)
    {
        $this->itemRequiredCollection = $irc->sort(false);

        return $this;
    }

    /**
     * @return ItemRequiredCollection
     */
    public function getItemRequiredCollection()
    {
        return $this->itemRequiredCollection;
    }

    public function calculate()
    {
        foreach ($this->itemRequiredCollection->getTypeIDs() as $typeID) { // each mineral
            $this->calculateMineral($typeID);
        }

        return $this->result;
    }

    public function calculateMineral($mineralTypeID)
    {

        $oreTypeID = $this->getPrimaryOre($mineralTypeID); // primary ore for this mineral

        if ($oreTypeID) { // primary ore exist calculate minerals
            $runs = $this->calculateByPrimaryOre($mineralTypeID, $oreTypeID);

            if ($runs) {
                $itemOre = new ItemResult([
                    'invType' => $runs[0],
                    'quantity' => $runs[1] // runs
                ]);

                $this->calculateOre($itemOre);
                $this->result[] = $itemOre;
            }
        }

        return $this;
    }

    private function calculateByPrimaryOre($mineralTypeID, $oreTypeID) // calculate regarding base items
    {
        $invType = InvTypes::findOne(['typeID' => $oreTypeID]); // ore
        $refineRuns = 0;

        foreach ($invType->invTypeMaterials as $invTypeMaterial) {
            if ($invTypeMaterial->materialTypeID == $mineralTypeID) {
                $refineRuns = ceil($this->getItemRequiredCollection()->getQuantityTotal($mineralTypeID) / $this->getRealQuantity($invTypeMaterial));     //  total we need / after refine

                break;
            }
        }

        return [$invType, $refineRuns];
    }

    private function calculateOre(ItemResult $itemResult) // calculate all minerals from ore by refine
    {
        foreach ($itemResult->invType->invTypeMaterials as $invTypeMaterial) {
            $quantity = ceil($this->getRealQuantity($invTypeMaterial) * $itemResult->getQuantity()); // (count after refine) * base quantity (runs)
            $itemResult->addItems(new ItemResult(['invType' => $invTypeMaterial->materialInvType, 'quantity' => $quantity]));

            $this->itemRequiredCollection->addQuantityWeHave($invTypeMaterial->materialTypeID, $quantity);
        }
    }

    private function getRealQuantity(InvTypeMaterials $invTypeMaterial)
    {
        return floor($invTypeMaterial->quantity * 0.84);
    }

    /**
     * Return typeID of ore.
     *
     * @param int $typeID // mineral type ID
     *
     * @return int|null
     */
    private function getPrimaryOre($typeID)
    {
        if (isset($this->primaryOre[$typeID])) {
            if ($this->primaryOre[$typeID]) {
                return $this->primaryOre[$typeID];
            }
        }

        return null;
    }
}