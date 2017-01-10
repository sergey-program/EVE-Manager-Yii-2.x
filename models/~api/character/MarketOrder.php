<?php

namespace app\models\api\character;

use app\models\extend\AbstractActiveRecord;
use app\models\InvTypes;
use app\models\StaStation;

/**
 * Class MarketOrder
 *
 * @package app\models\api\characters
 *
 * @property int    $id
 * @property int    $characterID
 * @property int    $orderID
 * @property int    $stationID
 * @property int    $volEntered
 * @property int    $volRemaining
 * @property int    $minVolume
 * @property int    $orderState
 * @property int    $typeID
 * @property int    $range
 * @property int    $accountKey
 * @property int    $duration
 * @property float  $escrow
 * @property float  $price
 * @property bool   $bid
 * @property string $issued
 */
class MarketOrder extends AbstractActiveRecord
{
    const ORDER_STATE_OPEN = 0; // or active
    const ORDER_STATE_CLOSED = 1;
    const ORDER_STATE_EXPIRED = 2; // or fulfilled
    const ORDER_STATE_CANCELLED = 3;
    const ORDER_STATE_PENDING = 4;
    const ORDER_STATE_CHAR_DELETED = 5;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'api_character_marketOrders';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['characterID', 'orderID', 'stationID', 'volEntered', 'volRemaining', 'minVolume', 'orderState', 'typeID', 'range', 'accountKey', 'duration', 'escrow', 'price', 'bid', 'issued'], 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID'
        ];
    }

    ### relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaStation()
    {
        return $this->hasOne(StaStation::className(), ['stationID' => 'stationID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvTypes()
    {
        return $this->hasOne(InvTypes::className(), ['typeID' => 'typeID']);
    }
}