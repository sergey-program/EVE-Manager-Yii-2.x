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
     */
    public function actionUpdate($force = false)
    {
        /** @var MarketPriceSchedule $marketUpdateGroup */
        $marketPriceSchedule = MarketPriceSchedule::find()->addOrderBy(['timeUpdated' => SORT_ASC])->limit(1)->one();
        $typeID = $marketPriceSchedule->typeID;

        if ($force) {
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
                echo "Cannot update typeID (" . $typeID . "), query is cached.\n";
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