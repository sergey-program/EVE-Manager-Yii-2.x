<?php

namespace app\modules\prices\updaters;

use app\components\eveCentral\EveCentral;
use app\modules\prices\models\PriceCron;
use yii\db\Expression;

class UpdaterEveCentral
{
    /**
     * Get last items and update.
     */
    public static function update($iBatch = 10)
    {
        $oQuery = PriceCron::find()->groupBy('typeID')->orderBy('date ASC');

        if (is_int($iBatch)) {
            $oQuery->limit($iBatch);
        }

        $aPriceCron = $oQuery->all();
        $oEveCentral = new EveCentral();

        foreach ($aPriceCron as $mPriceCron) {
            $oEveCentral->addTypeID($mPriceCron->typeID);
        }

        $oEveCentral->fetch();

        foreach ($aPriceCron as $mPriceCron) {
            $mPriceCron->date = new Expression('NOW()');

            if ($mPriceCron->validate()) {
                $mPriceCron->save();
            }
        }
    }

    /**
     * Add typeID to cron updater.
     *
     * @param $iTypeID
     */
    public static function addType($iTypeID)
    {
        $mPriceCron = PriceCron::findOne(['typeID' => $iTypeID]);

        if (!$mPriceCron) {
            $mPriceCron = new PriceCron();
            $mPriceCron->typeID = $iTypeID;
            $mPriceCron->date = null;

            if ($mPriceCron->validate()) {
                $mPriceCron->save();

                $oEveCentral = new EveCentral();
                $oEveCentral->addTypeID($iTypeID);
                $oEveCentral->fetch();
            }
        }
    }
}