<?php

namespace app\calls\eve;

use app\calls\extend\AbstractCall;
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
     * @param string $result
     *
     * @return bool
     */
    public function doUpdate($result)
    {
        $return = true;
        $xml = $this->createXmlObject($result);
        $stations = $xml->result->rowset->row;

        foreach ($stations as $station) {
            $data = self::getXmlAttr($station);

            /** @var ConquerableStation $conquerableStation */
            $conquerableStation = ConquerableStation::findOne(['stationID' => $data['stationID']]);

            if (!$conquerableStation) {
                $conquerableStation = new ConquerableStation();
                $conquerableStation->stationID = $data['stationID'];
                $conquerableStation->timeUpdate = time();
            } else {
                if ($conquerableStation->stationName != $data['stationName'] || $conquerableStation->corporationID != $data['corporationID']) {
                    // only owner and name can be changed in game, all others data is not changeable
                    $conquerableStation->timeUpdate = time();
                }
            }

            $conquerableStation->stationID = $data['stationID'];
            $conquerableStation->stationName = $data['stationName'];
            $conquerableStation->stationTypeID = $data['stationTypeID'];
            $conquerableStation->solarSystemID = $data['solarSystemID'];
            $conquerableStation->corporationID = $data['corporationID'];
            $conquerableStation->corporationName = $data['corporationName'];

            $return = ($conquerableStation->save() && $return);
        }

        return $return;
    }
}