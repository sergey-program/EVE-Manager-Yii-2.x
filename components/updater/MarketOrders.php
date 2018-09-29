<?php

namespace app\components\updater;

use app\components\api\EsiMarketOrders;
use app\models\MarketPrice;
use yii\base\Exception;

/**
 * Class MarketOrders
 *
 * @package app\components\updater
 */
class MarketOrders
{
    /** @var EsiMarketOrders|null $esiMarketOrders */
    private $esiMarketOrders;
    /** @var int $pageLimit */
    private $pageLimit = 350;

    /**
     * @param EsiMarketOrders $esiMarketOrders
     *
     * @return $this
     */
    public function setEsiMarketOrders(EsiMarketOrders $esiMarketOrders)
    {
        $this->esiMarketOrders = $esiMarketOrders;

        return $this;
    }

    /**
     * @param int $pageLimit
     *
     * @return $this
     */
    public function setPageLimit($pageLimit)
    {
        $this->pageLimit = $pageLimit;

        return $this;
    }

    /**
     * Get api data (orders).
     *
     * @param int $pages
     *
     * @return array
     *
     * @throws Exception
     */
    public function getPrices()
    {
        $result = [];

        for ($i = 1; $i <= $this->pageLimit; $i++) {
            $orders = $this->esiMarketOrders->getRows($i)->getOrders();

            if (isset($orders['error'])) {
                continue;
            }

            $result = $this->parseOrders($orders, $result);

            if (count($orders) < $this->esiMarketOrders->getMaxItems()) {
                break;
            }
        }

        return $result;
    }

    /**
     * @param array $orders
     * @param array $result
     *
     * @return array
     */
    public function parseOrders($orders, $result = [])
    {
        foreach ($orders as $order) {
            if ($order['location_id'] != '60003760') { // jita 4-4
                continue;
            }

            // add default values
            if (!isset($result[$order['type_id']])) {
                $result[$order['type_id']] = [
                    'buy' => 0,
                    'sell' => 0,
                    'type_id' => $order['type_id']
                ];
            }

            if ($order['is_buy_order']) {
                if ($result[$order['type_id']]['buy'] === 0 || ($result[$order['type_id']]['buy'] < $order['price'])) {
                    $result[$order['type_id']]['buy'] = $order['price'];
                }
            } else {
                if ($result[$order['type_id']]['sell'] === 0 || ($result[$order['type_id']]['sell'] > $order['price'])) {
                    $result[$order['type_id']]['sell'] = $order['price'];
                }
            }
        }

        return $result;
    }

    /**
     * @param array $prices
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function updateDB(array $prices)
    {
        if (empty($prices)) {
            return false;
        }

        foreach ($prices as $price) {
            /** @var MarketPrice|null $model */
            $model = MarketPrice::findOne(['typeID' => $price['type_id']]);

            if (!$model) {
                $model = new MarketPrice(['typeID' => $price['type_id']]);
            }

            $model->sell = $price['sell'];
            $model->buy = $price['buy'];
            $model->timeUpdate = time();

            if (!$model->save()) {
                return false;
            }
        }

        return true;
    }
}