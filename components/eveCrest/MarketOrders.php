<?php

namespace app\components\eveCrest;

use app\models\User;

/**
 * Class MarketOrders
 *
 * @package app\components\eveCrest
 */
class MarketOrders
{
    const ORDER_TYPE_SELL = 'sell';
    const ORDER_TYPE_BUY = 'buy';

    /**
     * @param string|int $typeID
     * @param string     $orderType
     *
     * @return int
     */
    public static function getPrice($typeID, $orderType)
    {
        $curl = curl_init();

        /** @var User $user */
        $user = User::find()->one();
        $user->token->refreshAccessToken(true);

        curl_setopt_array($curl, [
                CURLOPT_URL => 'https://crest-tq.eveonline.com/market/10000002/orders/' . $orderType . '/?type=https://crest-tq.eveonline.com/inventory/types/' . $typeID . '/',
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

        $bestPrice = null;

        if (isset($result['items'])) {
            foreach ($result['items'] as $item) {

                // use only jita 4-4
                if ($item['location']['id_str'] != '60003760') {
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
        }

        curl_close($curl);

        return $bestPrice ? $bestPrice['price'] : 0;
    }
}