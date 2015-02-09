<?php

namespace app\calls\character;

use app\calls\_extend\AbstractCall;
use app\models\api\character\MarketOrder;

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
     * @param string $sResult
     */
    public function doUpdate($sResult)
    {
        $oXml = $this->createXmlObject($sResult);
        $aOrder = $oXml->result->rowset->row;

        foreach ($aOrder as $oOrder) {
            $aData = self::getXmlAttr($oOrder);
            $mMarketOrder = MarketOrder::findOne(['characterID' => $aData['charID'], 'orderID' => $aData['orderID']]);

            if (!$mMarketOrder) {
                $mMarketOrder = new MarketOrder();
                $mMarketOrder->characterID = $aData['charID'];
                $mMarketOrder->orderID = $aData['orderID'];
            }

            $mMarketOrder->stationID = $aData['stationID'];
            $mMarketOrder->volEntered = $aData['volEntered'];
            $mMarketOrder->volRemaining = $aData['volRemaining'];
            $mMarketOrder->minVolume = $aData['minVolume'];
            $mMarketOrder->orderState = $aData['orderState'];
            $mMarketOrder->typeID = $aData['typeID'];
            $mMarketOrder->range = $aData['range'];
            $mMarketOrder->accountKey = $aData['accountKey'];
            $mMarketOrder->duration = $aData['duration'];
            $mMarketOrder->escrow = $aData['escrow'];
            $mMarketOrder->price = $aData['price'];
            $mMarketOrder->bid = $aData['bid'];
            $mMarketOrder->issued = date($aData['issued']);

            if ($mMarketOrder->validate()) {
                $mMarketOrder->save();
            }
        }
    }
}