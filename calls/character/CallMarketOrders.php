<?php

namespace app\calls\character;

use app\calls\extend\AbstractCall;
use app\models\api\character\MarketOrder;

/**
 * Class CallMarketOrders
 *
 * @package app\calls\character
 */
class CallMarketOrders extends AbstractCall
{
    public $keyID;
    public $vCode;
    public $characterID;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->getApiUrl() . '/char/MarketOrders.xml.aspx?keyID=' . $this->keyID . '&vCode=' . $this->vCode . '&characterID=' . $this->characterID;
    }

    /**
     * @param string $result
     *
     * @return bool
     */
    public function doUpdate($result)
    {
        $return = true;
        $xmlObj = $this->createXmlObject($result);
        $orders = $xmlObj->result->rowset->row;

        foreach ($orders as $order) {
            $data = self::getXmlAttr($order);
            $marketOrder = MarketOrder::findOne(['characterID' => $data['charID'], 'orderID' => $data['orderID']]);

            if (!$marketOrder) {
                $marketOrder = new MarketOrder();
                $marketOrder->characterID = $data['charID'];
                $marketOrder->orderID = $data['orderID'];
            }

            $marketOrder->stationID = $data['stationID'];
            $marketOrder->volEntered = $data['volEntered'];
            $marketOrder->volRemaining = $data['volRemaining'];
            $marketOrder->minVolume = $data['minVolume'];
            $marketOrder->orderState = $data['orderState'];
            $marketOrder->typeID = $data['typeID'];
            $marketOrder->range = $data['range'];
            $marketOrder->accountKey = $data['accountKey'];
            $marketOrder->duration = $data['duration'];
            $marketOrder->escrow = $data['escrow'];
            $marketOrder->price = $data['price'];
            $marketOrder->bid = $data['bid'];
            $marketOrder->issued = date($data['issued']);

            $return = ($marketOrder->save() && $return);
        }

        return $return;
    }
}