<?php

namespace app\controllers;

use app\components\eveEsi\MarketOrders;
use app\controllers\extend\AbstractController;

class TestController extends AbstractController
{
    public function actionIndex()
    {

        $ma = MarketOrders::getPrice(34);

        $bestPrice['buy'] = null;
        $bestPrice['sell'] = null;

        foreach ($ma as $item) {
            // use only jita 4-4
            if ($item['location_id'] != '60003760') {
                continue;
            }

            if ($item['is_buy_order']) {
                // assign first any price
                if (is_null($bestPrice['buy'])) {
                    $bestPrice['buy'] = $item;
                    continue;
                }

                if ($bestPrice['buy']['price'] < $item['price']) {
                    $bestPrice['buy'] = $item;
                }
            } else {
                // assign first any price
                if (is_null($bestPrice['sell'])) {
                    $bestPrice['sell'] = $item;
                    continue;
                }

                if ($bestPrice['sell']['price'] > $item['price']) {
                    $bestPrice['sell'] = $item;
                }
            }
        }

        var_dump($bestPrice);
//        echo '<pre>';
//        print_r($ma);
//        echo '</pre>';

    }
}