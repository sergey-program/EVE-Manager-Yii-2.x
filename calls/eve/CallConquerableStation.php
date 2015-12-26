<?php

namespace app\calls\eve;

use app\calls\_extend\AbstractCall;
use app\models\api\eve\ConquerableStation;

/**
 * Class CallConquerableStation
 *
 * @package app\calls\eve
 */
class CallConquerableStation extends AbstractCall
{
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->getApiUrl() . '/eve/ConquerableStationList.xml.aspx';
    }

    /**
     * @param string $sResult
     */
    public function doUpdate($sResult)
    {
        $oXml = $this->createXmlObject($sResult);
        $aStation = $oXml->result->rowset->row;

        foreach ($aStation as $oStation) {
            $aData = self::getXmlAttr($oStation);
            $mConquerableStation = ConquerableStation::findOne(['stationID' => $aData['stationID']]);

            if (!$mConquerableStation) {
                $mConquerableStation = new ConquerableStation();
                $mConquerableStation->stationID = $aData['stationID'];
            }

            $mConquerableStation->stationID = $aData['stationID'];
            $mConquerableStation->stationName = $aData['stationName'];
            $mConquerableStation->stationTypeID = $aData['stationTypeID'];
            $mConquerableStation->solarSystemID = $aData['solarSystemID'];
            $mConquerableStation->corporationID = $aData['corporationID'];
            $mConquerableStation->corporationName = $aData['corporationName'];

            if ($mConquerableStation->validate()) {
                $mConquerableStation->save();
            }
        }
    }
}