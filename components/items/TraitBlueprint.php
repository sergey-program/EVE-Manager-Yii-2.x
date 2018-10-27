<?php

namespace app\components\items;

use app\models\BlueprintSettings;
use app\models\dump\IndustryActivityMaterials;
use app\models\dump\IndustryActivityProducts;

/**
 * Trait TraitBlueprint
 *
 * @package app\components\items
 */
trait TraitBlueprint
{
    /** @var BlueprintSettings|null $settings */
    protected $settings;
    /** @var Item|null|false $blueprint */
    protected $blueprint;
    /** @var Item|null|false $product */
    protected $product;

    protected $materials;

    /**
     * @return Item|false|null
     */
    public function getBlueprint()
    {
        if (is_null($this->blueprint)) {
            $filter = ['productTypeID' => $this->typeID, 'activityID' => 1];
            $industryActivityProduct = IndustryActivityProducts::find()->where($filter)->cache(60 * 60 * 24)->one();
            $this->blueprint = $industryActivityProduct ? new Item(['invType' => $industryActivityProduct->invType]) : false;
        }

        return $this->blueprint;
    }

    /**
     * @return Item|bool|false|null
     */
    public function getProduct()
    {
        if (is_null($this->product)) {
            $filter = ['typeID' => $this->typeID, 'activityID' => 1];
            $industryActivityProduct = IndustryActivityProducts::find()->where($filter)->cache(60 * 60 * 24)->one();
            $this->product = $industryActivityProduct ? new Item(['invType' => $industryActivityProduct->productType]) : false;
        }

        return $this->product;
    }

    /**
     * @return bool|Item[]
     */
    public function getMaterials()
    {
        if (is_null($this->materials)) {
            $filter = ['typeID' => $this->typeID, 'activityID' => 1];
            /** @var IndustryActivityMaterials $iams */
            $industryActivityMaterials = IndustryActivityMaterials::find()->where($filter)->all();

            if (empty($industryActivityMaterials)) {
                $this->materials = false;
            } else {
                foreach ($industryActivityMaterials as $industryActivityMaterial) {
                    $this->materials[] = $industryActivityMaterial->materialInvType->getItem();
                }
            }
        }

        return $this->materials;
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
        return $this->getBlueprint() ? true : false;
    }

    /**
     * @return bool
     */
    public function hasSettings()
    {
        return $this->settings ? true : false;
    }

    /**
     * @return BlueprintSettings|null
     */
    public function getSettings()
    {
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

        return $this->settings;
    }
}