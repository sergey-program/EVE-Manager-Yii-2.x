<?php

namespace app\models;

use app\models\dump\InvTypes;
use app\models\extend\AbstractActiveRecord;

/**
 * Class MarketPriceSchedule
 *
 * @package app\models
 *
 * @property int           $id
 * @property int           $typeID
 * @property int|\DateTime $timeUpdated
 *
 * @property InvTypes      $invType
 */
class MarketPriceSchedule extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%market_price_schedule}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['typeID', 'integer'],
            ['timeUpdated', 'integer']
        ];
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
    public function getInvType()
    {
        return $this->hasOne(InvTypes::class, ['typeID' => 'typeID']);
    }

    ### functions
}

