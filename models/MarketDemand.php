<?php

namespace app\models;

use app\models\extend\AbstractActiveRecord;
use app\models\api\character\MarketOrder;

/**
 * Class MarketDemand
 *
 * @package app\models
 *
 * @property int           $id
 * @property int           $characterID
 * @property int           $stationID
 * @property int           $typeID
 * @property int           $quantity
 * @property int           $type
 *
 * @property MarketOrder[] $orders
 * @property Price|null    $priceBuy
 * @property Price|null    $priceSell
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
            [['characterID', 'stationID', 'typeID', 'quantity', 'type'], 'required'],
            ['typeID', 'ruleUnique']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'stationID' => 'Station',
            'typeID' => 'Item',
            'characterID' => 'Character'
        ];
    }

    /**
     *
     */
    public function ruleUnique()
    {
        if (MarketDemand::findOne(['typeID' => $this->typeID, 'stationID' => $this->stationID])) {
            $this->addError('typeID', $this->invTypes->typeName . ' already added to list.');
        }
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

    /**
     * @return null|Price
     */
    public function getPriceBuy()
    {
        return Price::findOne(['typeID' => $this->typeID, 'type' => Price::TYPE_BUY]);
    }

    /**
     * @return null|Price
     */
    public function getPriceSell()
    {
        return Price::findOne(['typeID' => $this->typeID, 'type' => Price::TYPE_SELL]);
    }

    ### function

    /**
     * @return int
     */
    public function getCountOrders()
    {
        $count = 0;

        if ($this->orders) {
            foreach ($this->orders as $marketOrder) {
                $count += $marketOrder->volRemaining;
            }
        }

        return $count;
    }

    /**
     * @return int
     */
    public function getCountNeed()
    {
        if ($this->getCountOrders() > $this->quantity) {
            return 0;
        }

        return ($this->quantity - $this->getCountOrders());
    }

    /**
     * @param bool $transportPrice
     * @param bool $stationPercent
     *
     * @return int
     */
    public function getMarginPriceBuy($transportPrice = true, $stationPercent = true)
    {
        $price = 0;
        $percent = \Yii::$app->params['demand']['percent']['buy'];

        if ($this->priceBuy && $this->priceBuy->max) {
            $priceOriginal = $this->priceBuy->max;

            $pricePercent = $priceOriginal * ($percent / 100);
            $price = $priceOriginal - $pricePercent;

            if ($transportPrice) {
                $price -= $this->getTransportPrice();
            }

            if ($stationPercent) {
                $price -= $this->getStationPercent($priceOriginal);
            }
        }

        return $price;
    }

    /**
     * @param bool $transportPrice
     * @param bool $stationPercent
     *
     * @return int
     */
    public function getMarginPriceSell($transportPrice = true, $stationPercent = true)
    {
        $price = 0;
        $percent = \Yii::$app->params['demand']['percent']['sell'];

        if ($this->priceSell && $this->priceSell->min) {
            $priceOriginal = $this->priceSell->min;

            $pricePercent = $priceOriginal * ($percent / 100);
            $price = $priceOriginal + $pricePercent;

            if ($transportPrice) {
                $price += $this->getTransportPrice();
            }

            if ($stationPercent) {
                $price += $this->getStationPercent($priceOriginal);
            }
        }

        return $price;
    }

    /**
     * @return int
     */
    public function getTransportPrice()
    {
        $price = 0;
        $item = $this->invTypes;
        $pricePerM3 = \Yii::$app->params['demand']['iskPerM3'];

        if ($item && $item->volume && $pricePerM3) {
            $price = $item->volume * $pricePerM3;
            // @todo in db there is no repackaged volume
        }

        return $price;
    }

    /**
     * @param float $priceOrigin
     *
     * @return int
     */
    public function getStationPercent($priceOrigin)
    {
        $price = 0;
        $stationPercent = \Yii::$app->params['demand']['stationPercent'];

        if ($priceOrigin) {
            $price = $priceOrigin * ($stationPercent / 100);
        }

        return $price;
    }
}