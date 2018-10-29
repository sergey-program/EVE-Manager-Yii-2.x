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
    /** @var Item|null|false $blueprint */
    protected $blueprint;
    /** @var BlueprintSettings|null $blueprintSettings */
    protected $blueprintSettings;
    /** @var Item|null|false $blueprintProduct */
    protected $blueprintProduct;
    /** @var Item[]|null|false $blueprintMaterials */
    protected $blueprintMaterials;
    /** @var int $blueprintRuns */
    protected $blueprintRuns = 1;

    /**
     * @param int $runs
     *
     * @return $this
     */
    public function setRuns($runs)
    {
        $this->blueprintRuns = $runs;

        return $this;
    }

    /**
     * @return int
     */
    public function getRuns()
    {
        return $this->blueprintRuns;
    }

    /**
     * @param int|null $quantity
     *
     * @return null
     */
    public function calculateRuns($quantity = null)
    {
        // @todo bpo can do 100\40\1 per run, recalculate it
        return is_null($quantity) ? $this->getQuantity() : $quantity;
    }

    /**
     * @return Item|false|null
     */
    public function getBlueprint()
    {
        if (is_null($this->blueprint)) {
            $filter = ['productTypeID' => $this->typeID, 'activityID' => 1];
            $product = IndustryActivityProducts::find()->where($filter)->cache(60 * 60 * 24)->one();
            $this->blueprint = $product ? new Item(['invType' => $product->invType, 'runs' => $this->calculateRuns()]) : false;
        }

        return $this->blueprint;
    }

    /**
     * What this bpo produces.
     *
     * @return Item|bool|false|null
     */
    public function getProduct()
    {
        if (is_null($this->blueprintProduct)) {
            $filter = ['typeID' => $this->typeID, 'activityID' => 1];
            $product = IndustryActivityProducts::find()->where($filter)->cache(60 * 60 * 24)->one();
            $this->blueprintProduct = $product ? new Item(['invType' => $product->productType]) : false;
        }

        return $this->blueprintProduct;
    }

    /**
     * Return calculated list of items for manufacture.
     *
     * @return Item[]|bool
     */
    public function getMaterials()
    {
        if (is_null($this->blueprintMaterials)) {
            $materials = IndustryActivityMaterials::find()->where(['typeID' => $this->typeID, 'activityID' => 1])->cache(60 * 60 * 24)->all();

            if (empty($materials)) {
                $this->blueprintMaterials = false;
            } else {
                foreach ($materials as $material) {
                    $item = $material->materialInvType->getItem();
                    $item->setQuantity($material->quantity);
                    $item->setParentBlueprint($this); // remember parent bpo to apply me\te

                    $this->blueprintMaterials[] = $item;
                }
            }
        }

        return $this->blueprintMaterials;
    }

    /**
     * @param int $rawQuantity
     *
     * @return float|int
     */
    public function calculateQuantity($rawQuantity)
    {
        $me = 1 - ($this->getSettings()->me / 100);
        $meRig = 1 - ($this->getSettings()->meRig / 100);
        $meHull = 1 - ($this->getSettings()->meHull / 100);

        return ceil($rawQuantity * $me * $meRig * $meHull); // * $this->getRuns();
    }

    /**
     * This item has bpo settings (me\te\runPrice).
     *
     * @return bool
     */
    public function hasSettings()
    {
        return $this->getSettings() ? true : false;
    }

    /**
     * Current item is bpo.
     *
     * @return bool
     */
    public function isBlueprint()
    {
        return is_int(strpos($this->typeName, 'Blueprint'));
    }

    /**
     * @return BlueprintSettings|null
     */
    public function getSettings()
    {
        $filter = ['userID' => \Yii::$app->user->id, 'typeID' => $this->typeID];
        $settings = BlueprintSettings::findOne($filter);

        if (!$settings) { // create empty entry to have zero defaults
            $settings = new BlueprintSettings($filter);
            $settings->save();
        }

        $this->blueprintSettings = $settings;

        return $this->blueprintSettings;
    }
}
