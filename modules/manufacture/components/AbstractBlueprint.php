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
    /** @var int $meBonus */
    private $meBonus = 0;
    /** @var int $teBonus */
    private $teBonus = 0;
    /** @var array|MItem[] $mItems */
    private $mItems = [];
    /** @var IndustryActivityMaterials[]|array $industryActivityMaterials */
    private $industryActivityMaterials = [];

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
            $rig = 1 - (4.2 /100); // 2% * 2.1 @todo create calculator for citadels
            $hull = 1 - ($this->getMeBonus()/100); // @todo calculate hull me bonus

            $qty = ceil($mItem->getBaseQuantity() * $me * $rig * $hull);
            $mItem->setQuantity($qty);

//            $quantity = (($this->getME() > 0) || ($this->getMeBonus() > 0))
//                ? ceil($mItem->getBaseQuantity() - ($mItem->getBaseQuantity() * (($this->getMe() + $this->getMeBonus()) / 100)))
//                : $mItem->getBaseQuantity();

//            $mItem->setQuantity($quantity);
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

    /**
     * @param $meBonus
     *
     * @return $this
     */
    public function setMeBonus($meBonus)
    {
        $this->meBonus = $meBonus;
        $this->recalculateMaterials();

        return $this;
    }

    /**
     * @return int
     */
    public function getMeBonus()
    {
        return $this->meBonus;
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