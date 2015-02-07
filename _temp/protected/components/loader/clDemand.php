<?php

class clDemand
{
    const TYPE_SELL = MarketDemand::TYPE_SELL;
    const TYPE_BUY = MarketDemand::TYPE_BUY;

    /**
     * @param $sCharacterID
     * @param $sStationID
     *
     * @return array
     */
    public static function loadAllAsList($sCharacterID, $sStationID)
    {
        $aReturn = array();
        $aAttr = array('characterID' => $sCharacterID);

        if ($sStationID) {
            $aAttr['stationID'] = $sStationID;
        }

        $aDemand = MarketDemand::model()->findAllByAttributes($aAttr);

        foreach ($aDemand as $oDemand) {
            $aReturn[] = new cDemand($oDemand);
        }

        return $aReturn;
    }

    /**
     * @param string|int $sCharacterID
     *
     * @return array
     */
    public static function loadAllAsStationList($sCharacterID)
    {
        $aReturn = array();
        $aDemand = MarketDemand::model()->findAllByAttributes(array('characterID' => $sCharacterID), array('group' => 'stationID'));

        foreach ($aDemand as $oDemand) {
            $aReturn[] = new cStation($oDemand->stationID);
        }

        return $aReturn;
    }

    /**
     * @param string|int $sDemandID
     * @param bool       $bAsComponent
     *
     * @return MarketDemand|cDemand|null
     */
    public static function loadOne($sDemandID, $bAsComponent = true)
    {
        $oDemand = MarketDemand::model()->findAllByPk($sDemandID);

        return ($bAsComponent) ? new cDemand($oDemand) : $oDemand;
    }

    /**
     * @param string|int      $sCharacterID
     * @param string          $sDemandType
     * @param string|int|null $sStationID
     *
     * @return array
     */
    public static function loadAllWithType($sCharacterID, $sDemandType, $sStationID = null)
    {
        $aReturn = array();
        $aAttr = array('characterID' => $sCharacterID, 'demandType' => $sDemandType);

        if ($sStationID) {
            $aAttr['stationID'] = $sStationID;
        }

        foreach (MarketDemand::model()->findAllByAttributes($aAttr) as $oDemand) {
            $aReturn[] = new cDemand($oDemand);
        }

        return $aReturn;
    }
}