<?php

namespace app\models;

use app\models\_extend\AbstractActiveRecord;
use app\models\api\character\MarketOrder;
use app\modules\prices\models\Price;

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
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getPriceBuy()
    {
        return Price::find()->where(['typeID' => $this->typeID, 'type' => Price::TYPE_BUY])->one();
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getPriceSell()
    {
        return Price::find()->where(['typeID' => $this->typeID, 'type' => Price::TYPE_SELL])->one();
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
                $iCount += $mMarketOrder->volRemaining;
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

    /**
     * @param bool $bTransportPrice
     *
     * @return int
     */
    public function getMarginPriceBuy($bTransportPrice = true, $bStationPercent = true)
    {
        $iPrice = 0;
        $iPercent = \Yii::$app->params['demand']['percent']['buy'];

        if ($this->priceBuy && $this->priceBuy->max) {
            $iPriceOriginal = $this->priceBuy->max;

            $iPricePercent = $iPriceOriginal * ($iPercent / 100);
            $iPrice = $iPriceOriginal - $iPricePercent;

            if ($bTransportPrice) {
                $iPrice -= $this->getTransportPrice();
            }

            if ($bStationPercent) {
                $iPrice -= $this->getStationPercent($iPriceOriginal);
            }
        }

        return $iPrice;
    }

    /**
     * @param bool $bTransportPrice
     *
     * @return int
     */
    public function getMarginPriceSell($bTransportPrice = true, $bStationPercent = true)
    {
        $iPrice = 0;
        $iPercent = \Yii::$app->params['demand']['percent']['sell'];

        if ($this->priceSell && $this->priceSell->min) {
            $iPriceOriginal = $this->priceSell->min;

            $iPricePercent = $iPriceOriginal * ($iPercent / 100);
            $iPrice = $iPriceOriginal + $iPricePercent;

            if ($bTransportPrice) {
                $iPrice += $this->getTransportPrice();
            }
            //var_dump($iPrice);
            if ($bStationPercent) {
                $iPrice += $this->getStationPercent($iPriceOriginal);
            }
        }

        return $iPrice;
    }

    /**
     * @return int
     */
    public function getTransportPrice()
    {
        $iPrice = 0;
        $mItem = $this->invTypes;
        $iPricePerM3 = \Yii::$app->params['demand']['iskPerM3'];

        if ($mItem && $mItem->volume && $iPricePerM3) {
            $iPrice = $mItem->volume * $iPricePerM3;
            // @todo in db there is no repackaged volume
        }

        return $iPrice;
    }

    /**
     * @param float $iPriceOrigin
     *
     * @return int
     */
    public function getStationPercent($iPriceOrigin)
    {
        $iPrice = 0;
        $iStationPercent = \Yii::$app->params['demand']['stationPercent'];

        if ($iPriceOrigin) {
            $iPrice = $iPriceOrigin * ($iStationPercent / 100);
        }

        return $iPrice;
    }
}