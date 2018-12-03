<?php

namespace app\components\actions;

use app\components\api\EsiMarketOrders;
use app\components\updater\MarketOrders;
use app\models\MarketPriceSchedule;
use yii\base\BaseObject;

/**
 * Class ActionUpdatePrice
 *
 * @package app\components\actions
 */
class ActionUpdatePrice extends BaseObject
{
    /** @var int $cacheTime */
    public $cacheTime = 300; // in seconds

    /**
     * @param int $typeID
     *
     * @return bool
     */
    public function update($typeID)
    {
        $marketPriceSchedule = MarketPriceSchedule::findOne(['typeID' => $typeID]);

        if ($marketPriceSchedule && $this->canUpdate($typeID)) {
            try {
                $mo = new MarketOrders();
                $mo->setEsiMarketOrders(new EsiMarketOrders(['typeID' => $marketPriceSchedule->typeID]));
                $mo->updateDB($mo->getPrices());

                $marketPriceSchedule->timeUpdated = time();

                if (!$marketPriceSchedule->save()) {
                    throw new \Exception('Cannot update market update group model');
                }
            } catch (\Exception $exception) {
                return false;
            }

            return true;
        }
        return false;
    }

    /**
     * Return true if data is out of cache.
     *
     * @param int $typeID
     *
     * @return bool
     */
    public function canUpdate($typeID)
    {
        $marketPriceSchedule = MarketPriceSchedule::findOne(['typeID' => $typeID]);

        return (time() > ($marketPriceSchedule->timeUpdated + $this->cacheTime));
    }
}