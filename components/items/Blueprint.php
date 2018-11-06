<?php

namespace app\components\items;

use app\models\BlueprintSettings;
use app\models\dump\IndustryActivityMaterials;
use app\models\dump\IndustryActivityProducts;

/**
 * Class Blueprint
 *
 * @package app\components\items
 */
class Blueprint extends Item
{
    /**
     * All me\te settings that required for manufacturing.
     *
     * @var BlueprintSettings|null $settings
     */
    protected $settings;

    /**
     * What this blueprint produces.
     *
     * @var Item|null|false $produce
     */
    protected $produce;

    /** @var int $runs */
    protected $runs;

    /**
     * @var Item[]|null|false $materials
     */
    protected $materials;

    /**
     * What item invokes this blueprint.
     * Required to calculate how much runs we should do.
     *
     * @var Item $parentItem
     */
    public $parentItem;

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
     * @return BlueprintSettings|null
     */
    public function getSettings()
    {
        if (is_null($this->settings)) {
            $filter = ['userID' => \Yii::$app->user->id, 'typeID' => $this->typeID];
            $settings = BlueprintSettings::findOne($filter);

            if (!$settings) { // create empty entry to have zero defaults
                $settings = new BlueprintSettings($filter);
                $settings->save();
            }

            $this->settings = $settings;
        }

        return $this->settings;
    }

    /**
     * What this bpo produces.
     *
     * @return Item|bool|false|null
     */
    public function getProduce()
    {
        if (is_null($this->produce)) {
            $filter = ['typeID' => $this->typeID, 'activityID' => 1];
            $product = IndustryActivityProducts::find()->where($filter)->cache(60 * 60 * 24)->one();
            $this->produce = $product ? new Item(['invType' => $product->productType]) : false;
        }

        return $this->produce;
    }

    /**
     * @param int $runs
     *
     * @return $this
     */
    public function setRuns($runs)
    {
        $this->runs = $runs;

        return $this;
    }

    /**
     * @return int
     */
    public function getRuns()
    {
        // @todo refactor, recalculate items by portion site and bpo output
        $this->runs = $this->getParentItem()->getQuantity();

        return $this->runs;
    }

    /**
     * @param Item $item
     *
     * @return $this
     */
    public function setParentItem(Item $item)
    {
        $this->parentItem = $item;

        return $this;
    }

    /**
     * @return Item
     */
    public function getParentItem()
    {
        return $this->parentItem;
    }

    /**
     * Return calculated list of items for manufacture. Raw quantity.
     *
     * @return Item[]|bool
     */
    public function getMaterials()
    {
        if (is_null($this->materials)) {
            $materials = IndustryActivityMaterials::find()->where(['typeID' => $this->typeID, 'activityID' => 1])->cache(60 * 60 * 24)->all();

            if (empty($materials)) {
                $this->materials = false;
            } else {
                foreach ($materials as $material) {
                    $item = $material->materialInvType->getItem();
                    $item->setQuantity($material->quantity * $this->getRuns());
//                    $item->setParentBlueprint($this); // remember parent bpo to apply me\te

                    $this->materials[] = $item;
                }
            }
        }

        return $this->materials;
    }
}