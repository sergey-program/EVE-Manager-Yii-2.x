<?php

namespace app\modules\calculators\components;

/**
 * Class ItemRequired
 *
 * @package app\modules\calculators\components
 *
 * @property int $quantity
 * @property int $quantityWeHave
 *
 * @property int $quantityTotal
 */
class ItemRequired extends AbstractItem
{
    /**
     * Quantity that marked as "we have".
     *
     * @var int $quantityDone
     */
    private $quantityWeHave = 0;

    /**
     * @param int $quantityWeHave
     *
     * @return $this
     */
    public function addQuantityWeHave($quantityWeHave)
    {
        $this->quantityWeHave += $quantityWeHave;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantityWeHave()
    {
        return $this->quantityWeHave;
    }

    /**
     * @return int
     */
    public function getQuantityTotal()
    {
        return $this->getQuantity() - $this->getQuantityWeHave();
    }
}