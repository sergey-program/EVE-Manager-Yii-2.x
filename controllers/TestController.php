<?php

namespace app\controllers;

use app\components\eveEsi\MarketOrders;
use app\controllers\extend\AbstractController;

class TestController extends AbstractController
{
    public function actionIndex()
    {

        $ma = new MarketOrders();

        $rows = $ma->getRows(25);

        var_dump($rows);

        echo '<pre>';
//        print_r($rows);
        echo '<pre>';

//        echo '<pre>';
//        print_r($ma);
//        echo '</pre>';

    }
}