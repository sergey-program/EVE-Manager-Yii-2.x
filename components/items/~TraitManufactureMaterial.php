<?php

namespace app\components\items;

trait TraitManufactureMaterial
{
    /** @var int $baseQuantity */
    public $baseQuantity = 0;

    /**
     * @param int $baseQuantity
     *
     * @return $this
     */
    public function setBaseQuantity($baseQuantity)
    {
        $this->baseQuantity = $baseQuantity;

        return $this;
    }

    /**
     * @return int
     */
    public function getBaseQuantity()
    {
        return $this->baseQuantity;
    }
}