<?php

namespace app\models\dump;

use app\models\extend\AbstractActiveRecord;
use app\models\MarketPrice;

/**
 * Class InvTypes
 *
 * @package app\models\dump
 *
 * @property                    $typeID
 * @property                    $groupID
 * @property                    $typeName
 * @property                    $description
 * @property                    $mass
 * @property                    $volume
 * @property                    $capacity
 * @property                    $portionSize
 * @property                    $raceID
 * @property                    $basePrice
 * @property                    $published
 * @property                    $marketGroupID
 * @property                    $iconID
 * @property                    $soundID
 * @property                    $graphicID
 *
 * @property InvTypeMaterials[] $invTypeMaterials
 * @property MarketPrice        $marketPrice
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

    ### functions
}