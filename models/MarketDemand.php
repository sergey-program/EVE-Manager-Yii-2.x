<?php

namespace app\models;

use app\models\_extend\AbstractActiveRecord;
use app\models\api\character\MarketOrder;

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

    /**
     * @return static
     */
    public function getOrders()
    {
        return MarketOrder::find()->where([
            'characterID' => $this->characterID,
            'stationID' => $this->stationID,
            'typeID' => $this->typeID,
            'orderState' => MarketOrder::ORDER_STATE_OPEN
        ])->all();
    }

    ### function

    /**
     * @return int
     */
    public function getCountOrders()
    {
        $iCount = 0;

        if ($this->orders) {
            foreach ($this->orders as $mMarketOrder) {
                $iCount += $mMarketOrder->volEntered;
            }
        }

        return $iCount;
    }

    /**
     * @return int
     */
    public function getCountNeed()
    {
        if ($this->getCountOrders() > $this->quantity) {
            return 0;
        }

        return $this->quantity - $this->getCountOrders();
    }
}