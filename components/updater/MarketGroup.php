<?php

namespace app\components\updater;

use app\components\api\EsiMarketOrders;
use app\models\dump\InvTypes;
use app\models\MarketUpdateGroup;
use yii\base\BaseObject;

/**
 * Class MarketGroup
 *
 * @package app\components\updater
 */
class MarketGroup extends BaseObject
{
    /**
     * @param int $groupID
     *
     * @return bool
     */
    public static function update($groupID)
    {
        $marketUpdateGroup = MarketUpdateGroup::findOne(['groupID' => $groupID]);

        if (!$marketUpdateGroup) {
            $marketUpdateGroup = new MarketUpdateGroup(['groupID' => $groupID]);
        }

        if (time() > ($marketUpdateGroup->timeUpdate + 300)) { // @todo static data cached 300
            try {
                $invTypes = InvTypes::findAll(['groupID' => $groupID, 'published' => true]);

                foreach ($invTypes as $invType) {
                    $mo = new MarketOrders();
                    $mo->setEsiMarketOrders(new EsiMarketOrders(['typeID' => $invType->typeID]));
                    $mo->updateDB($mo->getPrices());
                }

                $marketUpdateGroup->timeUpdate = time();

                if (!$marketUpdateGroup->save()) {
                    throw new \Exception('Cannot update market update group model');
                }
            } catch (\Exception $exception) {
                return false;
            }

            return true;
        }

        return false;
    }
}