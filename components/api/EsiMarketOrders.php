<?php

namespace app\components\api;

use app\models\User;
use yii\base\BaseObject;

/**
 * Class EsiMarketOrders
 *
 * @package app\components\api
 */
class EsiMarketOrders extends BaseObject
{
    private $maxItems = 1000; // https://esi.evetech.net/ui#/Market/get_markets_region_id_orders

    /**
     * Result array of api call.
     *
     * @var array $orders
     */
    private $orders = [];

    /**
     * Filter api result by typeID.
     *
     * @var string|int $typeID
     */
    private $typeID;

    /**
     * Region where we gonna search. Default is Fourge (Jita) region.
     *
     * @var int|null|string $regionID
     */
    private $regionID = '10000002';

    private $orderType = 'all'; // @todo add

    public function getMaxItems()
    {
        return $this->maxItems;
    }

    /**
     * @param int $typeID
     *
     * @return $this
     */
    public function setTypeID($typeID)
    {
        $this->typeID = $typeID;

        return $this;
    }

    /**
     * @return int|string
     */
    public function getTypeID()
    {
        return $this->typeID;
    }

    /**
     * @param int $regionID
     *
     * @return $this
     */
    public function setRegionID($regionID)
    {
        $this->regionID = $regionID;

        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getRegionID()
    {
        return $this->regionID;
    }

    /**
     * @param int $page
     *
     * @return string
     */
    private function createUrl($page)
    {
        $url = 'https://esi.tech.ccp.is/latest/markets/' . $this->getRegionID() . '/orders?';
        $url .= $this->getTypeID() ? '&type_id=' . $this->getTypeID() : '';
        $url .= '&page=' . $page;
//$url .= '&order_type='.$this->orderType;
        return $url;
    }

    /**
     * @param int $page
     *
     * @return $this
     */
    public function getRows($page = 1)
    {
        $curl = curl_init();

        /** @var User $user */
        $user = User::find()->one();
//        $user->token->refreshAccessToken();

        curl_setopt_array($curl, [
                CURLOPT_URL => $this->createUrl($page),
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

        $this->orders = json_decode($resultString, true);

        return $this;
    }

    /**
     * @return array
     */
    public function getOrders()
    {
        return $this->orders;
    }
}