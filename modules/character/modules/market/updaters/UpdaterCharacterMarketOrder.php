<?php

namespace app\modules\character\modules\market\updaters;

use app\calls\character\CallMarketOrders;

class UpdaterCharacterMarketOrder
{
    /**
     * @param int    $keyID
     * @param string $vCode
     * @param int    $characterID
     */
    public static function update($keyID, $vCode, $characterID)
    {
        $oCallMarketOrders = new CallMarketOrders();
        $oCallMarketOrders->keyID = $keyID;
        $oCallMarketOrders->vCode = $vCode;
        $oCallMarketOrders->characterID = $characterID;

        $oCallMarketOrders->update();
    }
}