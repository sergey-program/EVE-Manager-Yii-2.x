<?php

namespace app\modules\marketUpdater\commands;

use app\components\updater\MarketGroup;
use app\models\MarketUpdateGroup;
use yii\console\Controller;

/**
 * Class MarketUpdaterController
 *
 * @package app\modules\marketUpdater\commands
 */
class MarketUpdaterController extends Controller
{
    const LOCK_NAME = 'market-updater';
    private $lockDuration = 60 * 10;

    /**
     *
     */
    public function actionUpdate()
    {
        $marketUpdateGroup = MarketUpdateGroup::find()->addOrderBy(['timeUpdate' => SORT_ASC])->limit(1)->one();

        if ($this->isLocked()) {
            echo 'Is locked. Run later' . "\n";
        } else {
            echo "Not locked. Locking...\n";
            $this->lock($marketUpdateGroup->groupID);
            echo "Updating... GroupID " . $marketUpdateGroup->groupID."\n";
            MarketGroup::update($marketUpdateGroup->groupID);
            echo "Update is done. Unlocking...\n";
            $this->unlock();
            echo "Unlocked.\n";
            echo "Done well.\n";
        }
    }

    /**
     * @return int|bool
     */
    private function isLocked()
    {
        return \Yii::$app->cache->get(self::LOCK_NAME);
    }

    /**
     * @param int $groupID
     *
     * @return bool
     */
    private function lock($groupID)
    {
        return \Yii::$app->cache->set(self::LOCK_NAME, $groupID, $this->lockDuration);
    }

    /**
     * @return bool
     */
    private function unlock()
    {
        return \Yii::$app->cache->delete(self::LOCK_NAME);
    }
}