<?php

namespace app\components\items;

trait TraitParentItem
{
    /**
     * This item used to manufacture of this bpo. Cannot be loaded automatically.
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

    /**
     * Quantity that requires for parent bpo (base).
     *
     * @return int
     */
    public function getParentQuantity()
    {
        $result = 0;

        /** @var Item $parentBlueprint */
        $parentBlueprint = $this->getParentBlueprint();

        if ($parentBlueprint && !empty($parentBlueprint->getBaseMaterials())) {
            foreach ($parentBlueprint->getBaseMaterials() as $material) {
                if ($this->typeID == $material->materialTypeID) {
                    $result = $material->quantity;
                    break;
                }
            }
        }

        return $result;
    }

}
