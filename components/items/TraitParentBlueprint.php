<?php

namespace app\components\items;

trait TraitParentBlueprint
{
    /**
     * This material was created\called by this bpo.
     *
     * @var Item $blueprint
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
     * @return Item
     */
    public function getParentBlueprint()
    {
        return $this->parentBlueprint;
    }
}