<?php

namespace app\components\eve\extend;

use app\components\eveEsi\MarketOrders;

/**
 * Class AbstractPriceItem
 *
 * @package app\components\eve
 */
abstract class AbstractPriceItem extends AbstractItem
{
    /** @var float|int $priceSell */
    public $priceSell;
    /** @var float|int $priceBuy */
    public $priceBuy;

    /**
     * @return $this
     */
    public function fetchPrices()
    {
        $marketOrders = new MarketOrders();
        $marketOrders->getRows($this->typeID);

        $this
            ->setPriceSell($marketOrders->getPrice(MarketOrders::ORDER_TYPE_SELL))
            ->setPriceBuy($marketOrders->getPrice(MarketOrders::ORDER_TYPE_BUY));

        return $this;
    }

    /**
     * @param float $priceSell
     *
     * @return $this
     */
    public function setPriceSell($priceSell)
    {
        $this->priceSell = $priceSell;

        return $this;
    }

    /**
     * @param int $quantity
     *
     * @return int
     */
    public function getPriceSell($quantity = 1)
    {
        if (is_null($this->priceSell)) {
            $this->fetchPrices();
        }

        return $this->priceSell * $quantity;
    }

    /**
     * @param float $priceBuy
     *
     * @return $this
     */
    public function setPriceBuy($priceBuy)
    {
        $this->priceBuy = $priceBuy;

        return $this;
    }

    /**
     * @param int $quantity
     *
     * @return int
     */
    public function getPriceBuy($quantity = 1)
    {
        if (is_null($this->priceBuy)) {
            $this->fetchPrices();
        }

        return $this->priceBuy * $quantity;
    }

}