<?php

namespace app\modules\marketUpdater\commands;

use app\models\MarketPriceSchedule;
use yii\console\Controller;

/**
 * Class MarketUpdaterController
 *
 * @package app\modules\marketUpdater\commands
 */
class MarketUpdaterController extends Controller
{
    const LOCK_NAME = 'market-updater';
    /** @var float|int $lockDuration */
    private $lockDuration = 60 * 10;

    /**
     * @param bool $force
     * @param int  $quantity
     */
    public function actionUpdate($force = false, $quantity = 5)
    {
        $quantity = is_numeric($quantity) ? $quantity : 1;

        /** @var MarketPriceSchedule $marketUpdateGroup */
        $marketPriceSchedules = MarketPriceSchedule::find()->addOrderBy(['timeUpdated' => SORT_ASC])->limit($quantity)->all();

        foreach ($marketPriceSchedules as $marketPriceSchedule) {
            $typeID = $marketPriceSchedule->typeID;
            echo 'Trying update typeID: ' . $typeID . "\n";

            if ($force) {
                echo "Force unlocking...\n";
                $this->unlock($typeID);
            }

            if ($this->isLocked($typeID)) {
                echo 'Is locked. Run later...' . "\n";
            } else {
                echo "Not locked.\n";
                if (\Yii::$app->actionUpdatePrice->canUpdate($typeID)) {
                    echo "Can update, out of cache.\n";
                    echo "Locking...\n";
                    $this->lock($typeID);
                    echo "Updating... TypeID " . $typeID . "\n";
                    \Yii::$app->actionUpdatePrice->update($typeID);
                    echo "Update is done. Unlocking...\n";
                    $this->unlock($typeID);
                    echo "Unlocked.\n";
                    echo "Done well.\n";
                } else {
                    echo "Cannot update typeID (" . $typeID . "), api data is cached.\n";
                }
            }
        }
    }

    /**
     * @param int $typeID
     *
     * @return int|bool
     */
    private function isLocked($typeID)
    {
        return \Yii::$app->cache->get($this->getLockName($typeID));
    }

    /**
     * @param int $typeID
     *
     * @return bool
     */
    private function lock($typeID)
    {
        return \Yii::$app->cache->set($this->getLockName($typeID), $typeID, $this->lockDuration);
    }

    /**
     * @param int $typeID
     *
     * @return bool
     */
    private function unlock($typeID)
    {
        return \Yii::$app->cache->delete($this->getLockName($typeID));
    }

    /**
     * @param int $typeID
     *
     * @return string
     */
    private function getLockName($typeID)
    {
        return self::LOCK_NAME . '-' . $typeID;
    }
}