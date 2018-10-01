<?php

namespace app\modules\manufacture\components;

/**
 * Class MItemMaterial
 *
 * Used in MBlueprint as child material.
 *
 * @package app\modules\manufacture\components
 */
class MItemMaterial extends MItem
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