<?php

namespace app\components\items;

/**
 * Trait TraitRequired
 *
 * @package app\components\items
 *
 * @property int $quantityWeHave
 */
trait TraitRequired
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
