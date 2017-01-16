<?php

namespace app\components\eveEsi;

use app\models\User;

/**
 * Class MarketOrders
 *
 * @package app\components\eveEsi
 */
class MarketOrders
{
    const ORDER_TYPE_SELL = 'sell';
    const ORDER_TYPE_BUY = 'buy';

    /**
     * @param string|int $typeID
     * @param string     $orderType
     * @param int        $regionID
     *
     * @return int
     */
    public static function getPrice($typeID, $orderType, $regionID = null)
    {
        $regionID = is_null($regionID) ? '10000002' : $regionID;
        $curl = curl_init();

        /** @var User $user */
        $user = User::find()->one();
        $user->token->refreshAccessToken();

        $params = [
            'type_id=' . $typeID,
            'order_type=' . $orderType,
            'page=1'
        ];

        $url = 'https://esi.tech.ccp.is/latest/markets/' . $regionID . '/orders?' . implode('&', $params);

        curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $user->token->accessToken,
                    'Accept: application/json'
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FRESH_CONNECT => true,
                CURLOPT_FOLLOWLOCATION => true
            ]
        );

        $resultString = curl_exec($curl);
        $result = json_decode($resultString, true);

//        echo '<pre>';
//        echo print_r($result);
//        echo '</pre>';
//        die();
        $bestPrice = null;


        foreach ($result as $item) {
            // use only jita 4-4
            if ($item['location_id'] != '60003760') {
                continue;
            }

            // assign first any price
            if (is_null($bestPrice)) {
                $bestPrice = $item;
                continue;
            }

            if ($orderType == self::ORDER_TYPE_SELL) {
                if ($bestPrice['price'] > $item['price']) {
                    $bestPrice = $item;
                }
            }

            if ($orderType == self::ORDER_TYPE_BUY) {
                if ($bestPrice['price'] < $item['price']) {
                    $bestPrice = $item;
                }
            }
        }

        curl_close($curl);

        return $bestPrice ? $bestPrice['price'] : 0;
    }
}