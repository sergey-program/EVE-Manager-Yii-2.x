<?php

namespace app\components\items;

use app\models\dump\IndustryActivityProducts;
use app\models\dump\InvTypes;

trait TraitBlueprint
{
    /** @var InvTypes|null $blueprint */
    protected $blueprint = null;

    /**
     * @return $this
     */
    protected function loadBlueprint()
    {
        if (is_null($this->blueprint)) {
            $iam = IndustryActivityProducts::find()->where([
                'productTypeID' => $this->typeID,
                'activityID' => 1
            ])->one();


            $this->blueprint = $iam ? $iam->invType : false;
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