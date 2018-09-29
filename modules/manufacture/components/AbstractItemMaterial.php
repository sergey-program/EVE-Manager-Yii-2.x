<?php

namespace app\modules\manufacture\components;

/**
 * Class AbstractItemMaterial
 *
 * Class used as child of blueprint.
 *
 * @package app\modules\manufacture\components
 */
abstract class AbstractItemMaterial extends AbstractItem
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