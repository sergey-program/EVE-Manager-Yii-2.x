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
    /** @var Item|null|false $child */
    protected $blueprint;
    /** @var BlueprintSettings|null $settings */
    protected $settings;
    /** @var Item|null|false $product */
    protected $product;
    /** @var Item[]|null|false $materials */
    protected $materials;

    /**
     * Return blueprint that uses to manufacture current item.
     *
     * @return Item|false|null
     */
    public function getBlueprint()
    {
        if (!$this->isBlueprint()) { // load only if item NOT blueprint
            if (is_null($this->blueprint)) {
                $filter = ['productTypeID' => $this->typeID, 'activityID' => 1];
                $product = IndustryActivityProducts::find()->where($filter)->cache(60 * 60 * 24)->one();
                $this->blueprint = $product ? new Item(['invType' => $product->invType]) : false;
            }
        }

        return $this->blueprint;
    }

    /**
     * Return item that can be manufactured by this item (bpo).
     *
     * @return Item|bool|false|null
     */
    public function getProduct()
    {
        if ($this->isBlueprint()) { // only bpo has materials
            if (is_null($this->product)) {
                $filter = ['typeID' => $this->typeID, 'activityID' => 1];
                $product = IndustryActivityProducts::find()->where($filter)->cache(60 * 60 * 24)->one();
                $this->product = $product ? new Item(['invType' => $product->productType]) : false;
            }
        }

        return $this->product;
    }

    /**
     * Return raw list of materials.
     *
     * @return IndustryActivityMaterials[]|array|null
     */
    public function getBaseMaterials()
    {
        if ($this->isBlueprint()) { // only bpo has materials
            return IndustryActivityMaterials::find()->where(['typeID' => $this->typeID, 'activityID' => 1])->all();
        }

        return null;
    }

    /**
     * Return calculated list of items for manufacture.
     *
     * @return bool|Item[]
     */
    public function getMaterials()
    {
        if ($this->isBlueprint()) { // only bpo has materials
            if (is_null($this->materials)) {
                $materials = $this->getBaseMaterials();

                if (empty($materials)) {
                    $this->materials = false;
                } else {
                    foreach ($materials as $material) {
                        $this->materials[] = $this->createMaterialItem($material); // before apply count me
                    }
                }
            }
        }

        return $this->materials;
    }

    /**
     * Create new child item (for manufacture), calculate real quantity using me (settings).
     *
     * @param IndustryActivityMaterials $material
     *
     * @return Item
     */
    private function createMaterialItem(IndustryActivityMaterials $material)
    {
        // calculate users quantity

        $me = 1 - ($this->getSettings()->me / 100);
        $meRig = 1 - ($this->getSettings()->meRig / 100);
        $meHull = 1 - ($this->getSettings()->meHull / 100);

        // @todo calculate settings runPrice and te

        $item = $material->materialInvType->getItem();
        $item->setQuantity(ceil($material->quantity * $me * $meRig * $meHull));
        $item->setParentBlueprint($this); // remember parent bpo

        return $item;
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
     * Check this item can be manufactured by bpo.
     *
     * @return bool
     */
    public function hasBlueprint()
    {
        return $this->getBlueprint() ? true : false;
    }

    /**
     * This item has bpo settings (me\te\runPrice).
     *
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
        if ($this->isBlueprint()) { // only bpo can own settings
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
}