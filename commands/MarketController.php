<?php

namespace app\commands;

use app\components\updater\MarketOrders;
use yii\console\Controller;

/**
 * Class MarketController
 *
 * @package app\commands
 */
class MarketController extends Controller
{
    /**
     *
     */
    public function actionUpdate()
    {
        $updater = new MarketOrders();
        $updater->getOrders()->updateDB();
    }
}