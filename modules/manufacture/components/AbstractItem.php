<?php

namespace app\modules\manufacture\components;

use app\models\dump\IndustryActivityProducts;
use app\models\dump\InvTypes;
use app\models\MarketPrice;

/**
 * Class AbstractItem
 *
 * Class used as prent of blueprint.
 *
 * @package app\modules\manufacture\components
 */
abstract class AbstractItem
{
    /** @var MBlueprint|null $mBlueprint */
    protected $mBlueprint = false;
    /** @var MarketPrice|null $marketPrice */
    protected $marketPrice = false;
    /** @var InvTypes|null $invType */
    protected $invType;
    /** @var int $quantity */
    protected $quantity;

    /**
     * MItem constructor.
     *
     * @param InvTypes $invType
     * @param int      $quantity
     */
    public function __construct(InvTypes $invType, $quantity = 1)
    {
        $this->invType = ($invType);
        $this->quantity = $quantity;
        $this->loadBlueprint();
    }

    /**
     * @return $this
     */
    private function loadBlueprint()
    {
        if (!$this->invType) {
            $this->mBlueprint = null;

            return $this;
        }

        if ($this->mBlueprint === false) {
            $iap = IndustryActivityProducts::find()->where(['and', ['activityID' => '1'], ['productTypeID' => $this->invType->typeID]])->cache(60 * 60 * 24)->one();

            if ($iap) {
                $invType = InvTypes::find()->where(['typeID' => $iap->typeID])->cache(60 * 60 * 24)->one(); // blueprint
                // @todo function recalculate quantity vs quantity pre bpo run (fuel blocks 40 per 1 run)
                $this->setBlueprint(new MBlueprint($invType, $this->quantity));
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function recalculateMaterials()
    {
        if ($this->hasBlueprint()) {
            $this->getBlueprint()->setRuns($this->quantity);
        }

        return $this;
    }

    /**
     * @param MBlueprint|null $mBlueprint
     *
     * @return $this
     */
    public function setBlueprint(MBlueprint $mBlueprint = null)
    {
        $this->mBlueprint = $mBlueprint;

        return $this;
    }

    /**
     * @return MBlueprint|null
     */
    public function getBlueprint()
    {
        return $this->mBlueprint;
    }

    /**
     * @return bool
     */
    public function hasBlueprint()
    {
        return ($this->mBlueprint instanceof MBlueprint) ? true : false;
    }

    /**
     * @return MarketPrice|array|bool|null|\yii\db\ActiveRecord
     */
    public function getMarketPrice()
    {
        if ($this->marketPrice === false) {
            $this->marketPrice = MarketPrice::find()->where(['typeID' => $this->getInvType()->typeID])->cache(60 * 2)->one();
        }

        return $this->marketPrice;
    }

    /**
     * @return InvTypes|null
     */
    public function getInvType()
    {
        return $this->invType;
    }

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
     * @param int $typeID
     *
     * @return bool
     */
    public function isTypeID($typeID)
    {
        return $this->getInvType() ? ($this->getInvType()->typeID == $typeID) : false;
    }

    /**
     * @param int $default
     *
     * @return float|int
     */
    public function getPriceBuy($default = 0)
    {
        if ($this->getMarketPrice()) {
            return $this->marketPrice->buy;
        }

        return $default;
    }

    /**
     * @param int $default
     *
     * @return float|int
     */
    public function getPriceBuyTotal($default = 0)
    {
        if ($this->getMarketPrice()) {
            return ($this->quantity * $this->getMarketPrice()->buy);
        }

        return $default;
    }

    /**
     * @param int $default
     *
     * @return float|int
     */
    public function getPriceSell($default = 0)
    {
        if ($this->getMarketPrice()) {
            return $this->marketPrice->sell;
        }

        return $default;
    }

    /**
     * @param int $default
     *
     * @return float|int
     */
    public function getPriceSellTotal($default = 0)
    {
        if ($this->getMarketPrice()) {
            return ($this->quantity * $this->getMarketPrice()->sell);
        }

        return $default;
    }

    /**
     * @param $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->recalculateMaterials();

        return $this;
    }

    /**
     * @param int $quantity
     *
     * @return $this
     */
    public function addQuantity($quantity)
    {
        $this->quantity += $quantity;
        $this->recalculateMaterials();

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}