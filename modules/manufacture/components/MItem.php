<?php

namespace app\modules\manufacture\components;

use app\models\dump\InvTypes;
use app\models\MarketPrice;

/**
 * Class MItem
 *
 * @package app\modules\manufacture\components
 */
class MItem extends AbstractItem
{
    /** @var MBlueprint|null $mBlueprint */
    private $mBlueprint;
    /** @var MarketPrice|null $marketPrice */
    private $marketPrice = false;

    /**
     * MItem constructor.
     *
     * @param InvTypes $invType
     * @param int      $quantity
     */
    public function __construct(InvTypes $invType, $quantity = 1)
    {
        $this->setInvType($invType);
        $this->setQuantity($quantity);
        $this->mBlueprint = MManager::createBlueprint($this->getInvType());
    }

    /**
     * @return bool
     */
    public function hasBlueprint()
    {
        return is_null($this->mBlueprint) ? false : true;
    }

    /**
     * @return MBlueprint|null
     */
    public function getBlueprint()
    {
        return $this->mBlueprint;
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
}