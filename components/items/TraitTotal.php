<?php

namespace app\components\items;

/**
 * Trait TraitTotal
 *
 * @package app\components\items
 */
trait TraitTotal
{
    /** @var Item[]|null|array */
    public $totalManufacture = [];

    /**
     * @param bool $force
     *
     * @return Item[]|null|array
     */
    public function getTotalManufacture($force = false)
    {
        if ($this->isBlueprint()) {
            if (empty($this->totalManufacture) || $force) {

                /** @var Item[] $materials */
                $materials = $this->getMaterials();

                if (!empty($materials)) {
                    foreach ($materials as $material) {
                        if ($material->hasBlueprint()) {

                            $totalMaterial = $material->getBlueprint()->getTotalManufacture($force);

                            foreach ($totalMaterial as $item) {
                                if (isset($this->totalManufacture[$item->typeID])) {
                                    $this->totalManufacture[$item->typeID]->addQuantity($item->getQuantityTotal());
                                } else {
                                    $this->totalManufacture[$item->typeID] = clone $item;
                                }
                            }
                        } else {
                            $this->totalManufacture[$material->typeID] = clone $material;
                        }
                    }
                }
            }
        }

        return $this->totalManufacture;
    }

    /**
     * @return float|int
     */
    public function getTotalPriceBuy()
    {
        $result = 0;
        $items = $this->getTotalManufacture();

        if (!empty($items)) {
            foreach ($items as $item) {
                $result += $item->getPriceTotalBuy();
            }
        }

        return $result;
    }

    /**
     * @return float|int
     */
    public function getTotalPriceSell()
    {
        $result = 0;
        $items = $this->getTotalManufacture();

        if (!empty($items)) {
            foreach ($items as $item) {
                $result += $item->getPriceTotalSell();
            }
        }

        return $result;
    }
}
