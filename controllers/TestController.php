<?php

namespace app\controllers;

use app\components\eveEsi\MarketOrders;
use app\controllers\extend\AbstractController;
use app\models\User;

class TestController extends AbstractController
{
    public function actionIndex()
    {

        $ma = MarketOrders::getPrice(34,MarketOrders::ORDER_TYPE_SELL);


        var_dump($ma);
        echo '<pre>';
        print_r($ma);
        echo '</pre>';

    }
}