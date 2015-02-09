<?php

namespace app\models;

use app\models\_extend\AbstractActiveRecord;

/**
 * Class MarketDemand
 *
 * @package app\models
 *
 * @var $id
 * @var $characterID
 * @var $stationID
 * @var $typeID
 * @var $quantity
 * @var $type
 */
class MarketDemand extends AbstractActiveRecord
{
    const TYPE_SELL = 'sell';
    const TYPE_BUY = 'buy';

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'market_demand';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['characterID', 'stationID', 'typeID', 'quantity', 'type'], 'required']
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
    public function getInvTypes()
    {
        return $this->hasOne(InvTypes::className(), ['typeID' => 'typeID']);
    }

    ### function
}