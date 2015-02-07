<?php

class clPrice
{
    /**
     * @param string|int $sTypeID
     * @param string|int $sSolarSystemID
     */
    public static function loadOne($sTypeID, $sSolarSystemID = 30000142) // jita 4-IV
    {

        $oPriceLoader = new cPriceLoader(); // jita 4-IV cnap
        $oPriceLoader
            ->setSolarSystemID($sSolarSystemID)
            ->setTypeID($sTypeID)
            ->load();

        return $oPriceLoader->getPrice($sTypeID);
    }
}