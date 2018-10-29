<?php

namespace app\components\items;

use app\models\MarketPrice;

/**
 * Trait TraitPrice
 *
 * @package app\components\items
 *
 * @property MarketPrice|null|bool $marketPrice
 */
trait TraitPrice
{
    /** @var null|MarketPrice $marketPrice */
    private $marketPrice;

    /**
     * @return MarketPrice|bool|null
     */
    public function getMarketPrice()
    {
        if (is_null($this->marketPrice)) {
            $marketPrice = MarketPrice::findOne(['typeID' => $this->invType->typeID]);
            $this->marketPrice = $marketPrice ? $marketPrice : false;
        }

        return $this->marketPrice;
    }

    /**
     * @return float|int
     */
    public function getPriceBuy()
    {
        return $this->getMarketPrice() ? $this->marketPrice->buy : 0;
    }

    /**
     * @return float|int
     */
    public function getPriceSell()
    {
        return $this->getMarketPrice() ? $this->marketPrice->sell : 0;
    }

    /**
     * @param bool $withME
     *
     * @return float|int
     */
    public function getPriceTotalSell($withME = true)
    {
        return $this->getQuantity($withME) * $this->getPriceSell();
    }

    /**
     * @param bool $withME
     *
     * @return float|int
     */
    public function getPriceTotalBuy($withME = true)
    {
        return $this->getQuantity($withME) * $this->getPriceBuy();
    }
}