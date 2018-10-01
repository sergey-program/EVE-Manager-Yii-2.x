<?php

namespace app\modules\manufacture\components;

use app\models\dump\IndustryActivityMaterials;
use app\models\dump\InvTypes;

/**
 * Class AbstractItem
 *
 * @package app\modules\manufacture\components
 */
abstract class AbstractBlueprint
{
    /** @var InvTypes|null $invType */
    private $invType;
    /** @var int $runs */
    private $runs = 1;
    /** @var int $me */
    private $me = 0;
    /** @var int $te */
    private $te = 0;
    /** @var int $meHull */
    private $meHull = 0;
    /** @var float $meRig */
    private $meRig = 4.2; // 2% * 2.1 @todo create calculator for citadels

    /** @var int $teBonus */
    private $teBonus = 0;
    /** @var array|MItem[] $mItems */
    private $mItems = [];
    /** @var IndustryActivityMaterials[]|array $industryActivityMaterials */
    private $industryActivityMaterials = [];

    private $runPrice = 0;

    /**
     * MBlueprint constructor.
     *
     * @param InvTypes $invType // bpo
     * @param int      $runs
     */
    public function __construct(InvTypes $invType, $runs = 1)
    {
        $this->invType = $invType;
        $this->setRuns($runs);
        $this->loadMaterials();         // load base (qty=1) materials
        $this->recalculateMaterials();  // recalculate qty regarding runs
    }

    /**
     * @return $this
     */
    private function loadMaterials()
    {
        $this->mItems = [];
        /** @var IndustryActivityMaterials[] $iam */
        $iam = $this->getInvType()->industryActivityMaterialsManufacture;

        if (!empty($iam)) {
            foreach ($iam as $invTypeMaterial) {
                $mItem = MManager::createItemMaterial($invTypeMaterial->materialTypeID);
                $mItem->setBaseQuantity($invTypeMaterial->quantity);

                $this->mItems[$invTypeMaterial->materialTypeID] = $mItem;
            }
        }

        return $this;
    }

    /**
     *
     */
    private function recalculateMaterials()
    {
        foreach ($this->mItems as $mItem) {
            $me = 1 - ($this->getME() / 100);
            $rig = 1 - ($this->getMeRig() / 100);
            $hull = 1 - ($this->getMeHull() / 100); // @todo calculate hull me bonus

            $qty = ceil($mItem->getBaseQuantity() * $me * $rig * $hull);
            $mItem->setQuantity($qty);
        }
    }

    /**
     * @param $runs
     *
     * @return $this
     */
    public function setRuns($runs)
    {
        $this->runs = $runs;

        return $this;
    }

    /**
     * @return int
     */
    public function getRuns()
    {
        return $this->runs;
    }

    /**
     * @param int $me
     *
     * @return $this
     */
    public function setME($me)
    {
        $this->me = $me;
        $this->recalculateMaterials();

        return $this;
    }

    /**
     * @return int
     */
    public function getME()
    {
        return $this->me;
    }

    /**
     * @param $te
     *
     * @return $this
     */
    public function setTE($te)
    {
        $this->te = $te;
        $this->recalculateMaterials();

        return $this;
    }

    /**
     * @return int
     */
    public function getTE()
    {
        return $this->te;
    }

    public function getMeRig()
    {
        return $this->meRig;
    }

    /**
     * @param int $me
     *
     * @return $this
     */
    public function setMeHull($me)
    {
        $this->meHull = $me;
        $this->recalculateMaterials();

        return $this;
    }

    /**
     * @return int
     */
    public function getMeHull()
    {
        return $this->meHull;
    }

    public function setRunPrice($runPrice)
    {
        $this->runPrice = $runPrice;

        return $this;
    }

    public function getRunPrice()
    {
        return $this->runPrice;
    }

    /**
     * @return array|MItem[]
     */
    public function getItems()
    {
        return $this->mItems;
    }

    /**
     * @return InvTypes|null
     */
    public function getInvType()
    {
        return $this->invType;
    }

    /**
     * @param int $typeID
     *
     * @return bool
     */
    public function isTypeID($typeID)
    {
        return $this->getInvType() ? ($this->getInvType()->typeID == $typeID) : false;
    }
}