<?php

class clOrder
{
    /**
     * Return array of orders;
     *
     * @param string|int      $sCharacterID
     * @param string|int|null $sStationID
     *
     * @return array
     */
    public static function loadAllAsList($sCharacterID, $sStationID = null)
    {
        $aReturn = array();
        $aAttr = array('characterID' => $sCharacterID, 'orderState' => ApiCharacterMarketOrders::ORDER_STATE_OPEN);

        if ($sStationID) {
            $aAttr['stationID'] = $sStationID;
        }

        $aOrder = ApiCharacterMarketOrders::model()->findAllByAttributes($aAttr);

        foreach ($aOrder as $oOrder) {
            $aReturn[] = new cOrder($oOrder);
        }

        return $aReturn;
    }

    /**
     * Return array of cStation components;
     *
     * @param string $sCharacterID
     *
     * @return array
     */
    public static function loadAllAsStationList($sCharacterID)
    {
        $aReturn = array();
        $aAttr = array('characterID' => $sCharacterID, 'orderState' => ApiCharacterMarketOrders::ORDER_STATE_OPEN);
        $aOrder = ApiCharacterMarketOrders::model()->findAllByAttributes($aAttr, array('group' => 'stationID'));

        foreach ($aOrder as $oOrder) {
            $aReturn[] = new cStation($oOrder->stationID);
        }

        return $aReturn;
    }

    /**
     * @param string|int $sCharacterID
     * @param string|int sTypeID
     * @param string|int $sStationID
     * @param int        $sBid
     *
     * @return array
     */
    public static function loadAllForDemand($sCharacterID, $sTypeID, $sStationID, $sBid)
    {
        $aReturn = array();
        $aAttr = array(
            'characterID' => $sCharacterID,
            'typeID' => $sTypeID,
            'stationID' => $sStationID,
            'orderState' => ApiCharacterMarketOrders::ORDER_STATE_OPEN,
            'bid' => $sBid
        );
        $aOrder = ApiCharacterMarketOrders::model()->findAllByAttributes($aAttr);

        foreach ($aOrder as $oOrder) {
            $aReturn[] = new cOrder($oOrder);
        }

        return $aReturn;
    }
}