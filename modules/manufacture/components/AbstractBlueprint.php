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
    protected $invType;
    /** @var MItem[]|array $mItems */
    protected $mItems = [];
    /** @var IndustryActivityMaterials[]|array $industryActivityMaterials */
    protected $industryActivityMaterials = [];

    /** @var int $runs */
    protected $runs = 1;
    /** @var int $runPrice */
    protected $runPrice = 0;

    /** @var int $me */
    protected $me = 0;
    /** @var int $te */
    protected $te = 0;

    /** @var int $meHull */
    protected $meHull = 0;
    /** @var int $teHull */
    protected $teHull = 0;

    /** @var float $meRig */
    protected $meRig = 4.2; // 2% * 2.1 @todo create calculator for citadels
    /** @var int $teRig */
    protected $teRig = 0;

    /** @return $this */
    abstract protected function recalculateMaterials();

    /**
     * @param InvTypes $invType
     *
     * @return $this
     */
    public function setInvType(InvTypes $invType)
    {
        $this->invType = $invType;

        return $this;
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

    /**
     * @param array|MItemMaterial[] $mItems
     *
     * @return $this
     */
    public function setItems($mItems)
    {
        if (is_array($mItems)) {
            foreach ($mItems as $mItem) {
                $this->addItem($mItem);
            }
        }

        return $this;
    }

    /**
     * @param MItemMaterial $mItem
     *
     * @return $this
     */
    public function addItem(MItemMaterial $mItem)
    {
        $this->mItems[] = $mItem;

        return $this;
    }

    /**
     * @return array|MItemMaterial[]
     */
    public function getItems()
    {
        return $this->mItems;
    }

    /**
     * @param int $runs
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
     * @param int $runPrice
     *
     * @return $this
     */
    public function setRunPrice($runPrice)
    {
        $this->runPrice = $runPrice;

        return $this;
    }

    /**
     * @return int
     */
    public function getRunPrice()
    {
        return $this->runPrice;
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
     * @param int $meHull
     *
     * @return $this
     */
    public function setMeHull($meHull)
    {
        $this->meHull = $meHull;
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

    /**
     * @param int $teHull
     *
     * @return $this
     */
    public function setTeHull($teHull)
    {
        $this->teHull = $teHull;

        return $this;
    }

    /**
     * @return int
     */
    public function getTeHull()
    {
        return $this->teHull;
    }

    /**
     * @param float|int $meRig
     *
     * @return $this
     */
    public function setMeRig($meRig)
    {
        $this->meRig = $meRig;
        $this->recalculateMaterials();

        return $this;
    }

    /**
     * @return float|int
     */
    public function getMeRig()
    {
        return $this->meRig;
    }
}