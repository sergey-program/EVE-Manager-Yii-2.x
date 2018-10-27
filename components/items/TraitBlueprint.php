<?php

namespace app\components\items;

use app\models\dump\IndustryActivityProducts;

/**
 * Trait TraitBlueprint
 *
 * @package app\components\items
 */
trait TraitBlueprint
{
    /** @var Item|null|false $blueprint */
    protected $blueprint = null;

    /**
     * @return $this
     */
    protected function loadBlueprint()
    {
        if (is_null($this->blueprint)) {
            $filter = ['productTypeID' => $this->typeID, 'activityID' => 1];
            $iam = IndustryActivityProducts::find()->where($filter)->cache(60 * 60 * 24)->one();
            $this->blueprint = $iam ? new Item(['invType' => $iam->invType]) : false;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function hasBlueprint()
    {
        return $this->blueprint ? true : false;
    }
}