<?php

class clStation
{
    /**
     * Load all stations from x2 tables;
     *
     * @param bool $bAsComponent
     *
     * @return array
     */
    public static function loadAll($bAsComponent = true)
    {
        $aReturn = array();
        $aStation = array_merge(StaStation::model()->findAll(), ApiCommonConquerableStationList::model()->findAll());

        foreach ($aStation as $oStation) {
            $aReturn[] = ($bAsComponent) ? new cStation($oStation) : $oStation;
        }

        return $aReturn;
    }

    /**
     * Load station by stationID; Return raw model if $bAsComponent === false;
     *
     * @param string|int $sStationID
     * @param bool       $bAsComponent
     *
     * @return cStation|ApiCommonConquerableStationList|StaStation
     */
    public static function loadOne($sStationID, $bAsComponent = true)
    {
        $aAttr = array('stationID' => $sStationID);
        $oStaStation = StaStation::model()->findByAttributes($aAttr);

        if ($oStaStation) {
            return ($bAsComponent) ? new cStation($oStaStation) : $oStaStation;
        }

        $oCnqStation = ApiCommonConquerableStationList::model()->findByAttributes($aAttr);

        if ($oCnqStation) {
            return ($bAsComponent) ? new cStation($oCnqStation) : $oCnqStation;
        }
    }
}