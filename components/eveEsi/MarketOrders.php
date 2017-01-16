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
    /** @var array */
    public $rows;
    /** @var int|null|string $regionID */
    public $regionID;

    const ORDER_TYPE_SELL = 'sell';
    const ORDER_TYPE_BUY = 'buy';

    /**
     * MarketOrders constructor.
     *
     * @param int|null $regionID
     */
    public function __construct($regionID = null)
    {
        $this->regionID = $regionID ? $regionID : '10000002';
    }

    /**
     * @param int    $typeID
     * @param string $regionID Default is Forge region.
     *
     * @return $this
     */
    public function getRows($typeID)
    {
        $curl = curl_init();

        /** @var User $user */
        $user = User::find()->one();
        $user->token->refreshAccessToken();

        $url = 'https://esi.tech.ccp.is/latest/markets/' . $this->regionID . '/orders?type_id=' . $typeID . '&page=1';

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
        curl_close($curl);

        $this->rows = json_decode($resultString, true);

        return $this;
    }

    /**
     * @param string $orderType
     *
     * @return int
     */
    public function getPrice($orderType)
    {
        $rowBest = null;

        foreach ($this->rows as $row) {
            if ($row['location_id'] != '60003760') { // use only jita 4-4
                continue;
            }

            if ($orderType == self::ORDER_TYPE_SELL && !$row['is_buy_order']) {
                if (is_null($rowBest)) {
                    $rowBest = $row;
                    continue;
                }

                if ($rowBest['price'] > $row['price']) {
                    $rowBest = $row;
                }
            }

            if ($orderType == self::ORDER_TYPE_BUY && $row['is_buy_order']) {
                if (is_null($rowBest)) {
                    $rowBest = $row;
                    continue;
                }

                if ($rowBest['price'] < $row['price']) {
                    $rowBest = $row;
                }
            }
        }

        return $rowBest ? $rowBest['price'] : 0;
    }
}