<?php

namespace app\components\updater;

use app\components\api\EsiMarketOrders;
use yii\base\Exception;

/**
 * Class MarketOrders
 *
 * @package app\components\updater
 */
class MarketOrders
{
    /**
     * @var array $prices
     */
    public $prices = [];

    /**
     * Get api data (orders).
     *
     * @return $this
     * @throws Exception
     */
    public function getOrders()
    {
        $esi = new EsiMarketOrders();

        for ($i = 1; $i <= 50; $i++) {
            $orders = $esi->getRows($i)->getOrders();

            if (isset($orders['error'])) {
                throw new Exception($orders['error']);
            }

            foreach ($orders as $order) {
                if ($order['location_id'] != '60003760') { // jita 4-4
                    continue;
                }

                // add default values
                if (!isset($this->prices[$order['type_id']])) {
                    $this->prices[$order['type_id']] = [
                        'buy' => 0,
                        'sell' => 0,
                        'type_id' => $order['type_id']
                    ];
                }

                if ($order['is_buy_order']) {
                    if ($this->prices[$order['type_id']]['buy'] === 0 || $this->prices[$order['type_id']]['buy'] < $order['price']) {
                        $this->prices[$order['type_id']]['buy'] = $order['price'];
                    }
                } else {
                    if ($this->prices[$order['type_id']]['sell'] === 0 || $this->prices[$order['type_id']]['sell'] > $order['price']) {
                        $this->prices[$order['type_id']]['sell'] = $order['price'];
                    }
                }
            }

            if (count($orders) < 10000) {
                break;
            }
        }

        return $this;
    }

    /**
     * You need call $this->getOrders() first to update db.
     *
     * @return bool
     */
    public function updateDB()
    {
        if (empty($this->prices)) {
            return false;
        }

        $values = [];

        foreach ($this->prices as $price) {
            $values[] = '("' . $price['type_id'] . '","' . $price['sell'] . '","' . $price['buy'] . '","' . time() . '")';
        }

        $sql = 'INSERT INTO _market_price (`typeID`, `sell`, `buy`, `timeUpdate`) VALUES ' . implode(',', $values);

        \Yii::$app->db->createCommand('TRUNCATE _market_price;')->execute();
        \Yii::$app->db->createCommand($sql)->execute();

        return true;
    }
}