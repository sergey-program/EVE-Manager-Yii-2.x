<?php

namespace app\components\items;

/**
 * Trait TraitReprocessable
 *
 * @package app\components\items
 *
 * @property int               $reprocessPercent
 * @property Item[]|array|null $reprocessResult
 */
trait TraitReprocessable
{
    /** @var int $percent */
    public $reprocessPercent = 84;
    /** @var Item[]|array $reprocessResult */
    public $reprocessResult = null;

    /**
     * @param int $percent
     *
     * @return $this
     */
    public function setReprocessPercent($percent)
    {
        $this->reprocessPercent = $percent;

        return $this;
    }

    /**
     * @return int
     */
    public function getReprocessPercent()
    {
        return $this->reprocessPercent;
    }

    /**
     * Quantity that user will receive after reprocess.
     *
     * @return float|int
     */
    public function getReprocessQuantity()
    {
        return ceil($this->getQuantity() * ($this->getReprocessPercent() / 100));
    }

    /**
     * Return items after reprocess.
     *
     * @return Item[]|array
     */
    public function getReprocessResult()
    {
        if (is_null($this->reprocessResult)) {
            $this->reprocess();
        }

        return $this->reprocessResult;
    }

    /**
     * @param Item $item
     *
     * @return Item
     */
    public function addReprocessResult(Item $item)
    {
        return $this->reprocessResult[] = $item;
    }

    /**
     * @return bool
     */
    public function isReprocessable()
    {
        return count($this->getInvType()->invTypeMaterials) ? true : false;
    }

    /**
     * @return $this
     */
    public function reprocess()
    {
        if ($this->isReprocessable()) {
            $invTypeMaterials = $this->getInvType()->invTypeMaterials;

            foreach ($invTypeMaterials as $invTypeMaterial) {
                $quantity = $invTypeMaterial->quantity * $this->getQuantity();
                $quantity = ceil($quantity * ($this->getReprocessPercent() / 100));

                $this->addReprocessResult(new Item(['invType' => $invTypeMaterial->materialInvType, 'quantity' => $quantity]));
            }
        } else {
            $this->addReprocessResult(new Item(['invType' => $this->getInvType(), 'quantity' => $this->getQuantity()]));
        }

        return $this;
    }

    public function getReprocessPriceBuy()
    {
        $result = 0;

        foreach ($this->reprocessResult as $item) {
            $result += $item->getPriceBuy() * $item->getReprocessQuantity();
        }

        return $result;
    }

    public function getReprocessPriceSell()
    {
        $result = 0;

        foreach ($this->reprocessResult as $item) {
            $result += $item->getPriceSell() * $item->getReprocessQuantity();
        }

        return $result;
    }
}