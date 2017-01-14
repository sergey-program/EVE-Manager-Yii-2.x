<?php

namespace app\controllers;

use app\controllers\extend\AbstractController;
use app\models\User;

class TestController extends AbstractController
{
    public function actionIndex()
    {
        $curl = curl_init();

        /** @var User $user */
        $user = User::find()->one();
        $user->token->refreshAccessToken(true);

        var_dump($user->token);

        curl_setopt_array($curl, [
                CURLOPT_URL => 'https://crest-tq.eveonline.com/market/10000002/orders/sell/?type=https://crest-tq.eveonline.com/inventory/types/34/',
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $user->token->accessToken,
                    'Accept: application/vnd.ccp.eve.RegionCollection-v1+json',
                    'Host: crest-tq.eveonline.com'
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FRESH_CONNECT => true
            ]
        );

        $resultString = curl_exec($curl);
        $result = json_decode($resultString, true);

        $itemBest = null;
        if (isset($result['items'])) {
            foreach ($result['items'] as $item) {
                if (!$itemBest) {
                    $itemBest = $item;
                    continue;
                }

                if ($itemBest['price'] > $item['price']) {
                    $itemBest = $item;
                }
            }
        }

        curl_close($curl);

        echo '<pre>';
        print_r($itemBest);
        echo '</pre>';

        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
}