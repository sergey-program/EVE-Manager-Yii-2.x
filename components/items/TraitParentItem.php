<?php

namespace app\components\items;

/**
 * Trait TraitParentItem
 *
 * @package app\components\items
 */
trait TraitParentItem
{
    /**
     * If $parentBlueprint set - this item is used for manufacture of something.
     * Cannot be loaded automatically.
     *
     * @var Item|null
     */
    public $parentBlueprint;

    /**
     * @param Item|TraitBlueprint $blueprint
     *
     * @return $this
     */
    public function setParentBlueprint(Item $blueprint)
    {
        $this->parentBlueprint = $blueprint;

        return $this;
    }

    /**
     * @return Item|null
     */
    public function getParentBlueprint()
    {
        return $this->parentBlueprint;
    }
}
