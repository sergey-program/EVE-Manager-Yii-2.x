<?php

namespace app\modules\prices\updaters;

use app\components\eveCentral\EveCentral;
use app\models\PriceCron;
use yii\db\Expression;

/**
 * Class UpdaterEveCentral
 *
 * @package app\modules\prices\updaters
 */
class UpdaterEveCentral
{
    /**
     * Get last items and update.
     *
     * @param int $limit
     */
    public static function update($limit = 100)
    {
        /** @var PriceCron[] $priceCrons */
        $priceCrons = PriceCron::find()->groupBy('typeID')->orderBy('timeUpdated ASC')->limit($limit)->all();
        $eveCentral = new EveCentral();

        foreach ($priceCrons as $priceCron) {
            $eveCentral->addTypeID($priceCron->typeID);
        }

        $eveCentral->fetch();

        foreach ($priceCrons as $priceCron) {
            $priceCron->timeUpdated = new Expression('NOW()');
            $priceCron->save();
        }
    }

    /**
     * Add typeID to cron updater.
     *
     * @param int $typeID
     */
    public static function addType($typeID)
    {
        $priceCron = PriceCron::findOne(['typeID' => $typeID]);

        if (!$priceCron) {
            $priceCron = new PriceCron();
            $priceCron->typeID = $typeID;
            $priceCron->timeUpdated = null;

            if ($priceCron->save()) {
                $eveCentral = new EveCentral();
                $eveCentral->addTypeID($typeID);
                $eveCentral->fetch();
            }
        }
    }
}