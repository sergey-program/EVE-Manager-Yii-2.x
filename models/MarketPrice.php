<?php

namespace app\models;

use app\models\dump\InvTypes;
use app\models\extend\AbstractActiveRecord;

/**
 * Class MarketPrice
 *
 * @package app\models
 *
 * @property int      $typeID
 * @property float    $sell
 * @property float    $buy
 * @property int      $timeUpdate
 *
 * @property InvTypes $invType
 */
class MarketPrice extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%market_price}}';
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
        return [
            'typeID' => 'Type ID'
        ];
    }

    ### relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvType()
    {
        return $this->hasOne(InvTypes::className(), ['typeID' => 'typeID']);
    }
    
    ### functions
}