<?php

namespace app\modules\station\updaters;

use app\calls\eve\CallConquerableStation;

class UpdaterEveConquerableStation
{
    /**
     *
     */
    public static function update()
    {
        $oCallConquerableStation = new CallConquerableStation();
        $oCallConquerableStation->update();
    }
}