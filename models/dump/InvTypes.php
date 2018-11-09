<?php

namespace app\models\dump;

use app\components\items\Blueprint;
use app\components\items\Item;
use app\models\extend\AbstractActiveRecord;
use app\models\MarketPrice;

/**
 * Class InvTypes
 *
 * @package app\models\dump
 *
 * @property                             $typeID
 * @property                             $groupID
 * @property                             $typeName
 * @property                             $description
 * @property                             $mass
 * @property                             $volume
 * @property                             $capacity
 * @property                             $portionSize
 * @property                             $raceID
 * @property                             $basePrice
 * @property                             $published
 * @property                             $marketGroupID
 * @property                             $iconID
 * @property                             $soundID
 * @property                             $graphicID
 *
 * @property InvTypeMaterials[]          $invTypeMaterials
 * @property MarketPrice                 $marketPrice
 * @property IndustryActivityMaterials[] $industryActivityMaterials
 * @property IndustryActivityMaterials[] $industryActivityMaterialsManufacture
 */
class InvTypes extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'invTypes';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    ### relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvTypeMaterials()
    {
        return $this->hasMany(InvTypeMaterials::class, ['typeID' => 'typeID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarketPrice()
    {
        return $this->hasOne(MarketPrice::class, ['typeID' => 'typeID']);
    }

    public function getIndustryActivityMaterials()
    {
        return $this->hasMany(IndustryActivityMaterials::class, ['typeID' => 'typeID']);
    }

    public function getIndustryActivityMaterialsManufacture($cacheTime = 60 * 60 * 24)
    {
        return $this->getIndustryActivityMaterials()->andWhere(['activityID' => '1'])->cache($cacheTime)->all();
    }

    public function getIndustryActivityMaterialsIn()
    {
        return $this->hasMany(IndustryActivityMaterials::class, ['materialTypeID' => 'typeID']);
    }

    /**
     * @param mixed $condition
     *
     * @return Blueprint|Item|null
     */
    public static function findItem($condition)
    {
        $invType = InvTypes::findOne($condition);

        return $invType ? $invType->getItem() : null;
    }

    ### functions

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
     * @param int $quantity
     *
     * @return Item|Blueprint
     */
    public function getItem($quantity = 1)
    {
        return $this->isBlueprint()
            ? new Blueprint(['invType' => $this, 'runs' => $quantity])
            : new Item(['invType' => $this, 'quantity' => $quantity]);
    }
}