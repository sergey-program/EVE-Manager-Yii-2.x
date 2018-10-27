<?php

namespace app\components\items;

use app\models\BlueprintSettings;
use app\models\dump\IndustryActivityProducts;

/**
 * Trait TraitBlueprint
 *
 * @package app\components\items
 */
trait TraitBlueprint
{
    /** @var BlueprintSettings|null $settings */
    public $settings;
    /** @var Item|null|false $blueprint */
    protected $blueprint;
    /** @var Item|null|false $product */
    protected $product;

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

        if ($this->isBlueprint()) {
            $settings = BlueprintSettings::findOne([
                'userID' => \Yii::$app->user->id,
                'typeID' => $this->typeID
            ]);

            if (!$settings) {
                $settings = new BlueprintSettings([
                    'userID' => \Yii::$app->user->id,
                    'typeID' => $this->typeID
                ]);
                $settings->save();
            }

            $this->settings = $settings;
        }

        return $this;
    }

    public function getProduct()
    {
        if (is_null($this->product)) {
            $filter = ['typeID' => $this->typeID, 'activityID' => 1];
            $iam = IndustryActivityProducts::find()->where($filter)->cache(60 * 60 * 24)->one();
            $this->product = $iam ? new Item(['invType' => $iam->productType]) : false;
        }

        return $this->product;
    }

    /**
     * @return bool
     */
    public function isBlueprint()
    {
        return is_int(strpos($this->typeName, 'Blueprint'));
    }

    /**
     * @return bool
     */
    public function hasBlueprint()
    {
        return $this->blueprint ? true : false;
    }

    /**
     * @return bool
     */
    public function hasSettings()
    {
        return $this->settings ? true : false;
    }

    /**
     * @return Item|false|null
     */
    public function getBlueprint()
    {
        return $this->blueprint;
    }

    /**
     * @return BlueprintSettings|null
     */
    public function getSettings()
    {
        return $this->settings;
    }
}