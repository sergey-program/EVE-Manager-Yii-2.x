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
    /** @var array $prices */
    public $prices = [];

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
     * @return array
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * Get api data (orders).
     *
     * @param int $pages
     *
     * @return $this
     *
     * @throws Exception
     */
    public function getOrders($pages = 350)
    {
        for ($i = 1; $i <= $pages; $i++) {
            $orders = $this->esiMarketOrders->getRows($i)->getOrders();

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
                    if ($this->prices[$order['type_id']]['buy'] === 0 || ($this->prices[$order['type_id']]['buy'] < $order['price'])) {
                        $this->prices[$order['type_id']]['buy'] = $order['price'];
                    }
                } else {
                    if ($this->prices[$order['type_id']]['sell'] === 0 || ($this->prices[$order['type_id']]['sell'] > $order['price'])) {
                        $this->prices[$order['type_id']]['sell'] = $order['price'];
                    }
                }
            }

            if (count($orders) < $this->esiMarketOrders->getMaxItems()) {
                break;
            }
        }

        return $this;
    }

    /**
     * @param array|null $prices
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function updateDB($prices = null)
    {
        $prices = is_null($prices) ? $this->prices : $prices;

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