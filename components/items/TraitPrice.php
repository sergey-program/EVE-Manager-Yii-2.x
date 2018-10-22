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
    private $marketPrice = null;

    /**
     * @return $this
     */
    private function loadMarketPrice()
    {
        if (is_null($this->marketPrice)) {
            $marketPrice = MarketPrice::findOne(['typeID' => $this->invType->typeID]);
            $this->marketPrice = $marketPrice ? $marketPrice : false;
        }

        return $this;
    }

    /**
     * @return float|int
     */
    public function getPriceBuy()
    {
        $this->loadMarketPrice();

        return $this->marketPrice ? $this->marketPrice->buy : 0;
    }

    /**
     * @return float|int
     */
    public function getPriceSell()
    {
        $this->loadMarketPrice();

        return $this->marketPrice ? $this->marketPrice->sell : 0;
    }

    /**
     * @return float|int
     */
    public function getPriceTotalSell()
    {
        return $this->getQuantity() * $this->getPriceSell();
    }

    /**
     * @return float|int
     */
    public function getPriceTotalBuy()
    {
        return $this->getQuantity() * $this->getPriceBuy();
    }
}