<?php

namespace app\models\api\characters;

use app\models\_extend\AbstractActiveRecord;

/**
 * Class MarketOrder
 *
 * @package app\models\api\characters
 * @var $id
 * @var $characterID
 * @var $orderID
 * @var $stationID
 * @var $volEntered
 * @var $volRemaining
 * @var $minVolume
 * @var $orderState
 * @var $typeID
 * @var $range
 * @var $accountKey
 * @var $duration
 * @var $escrow
 * @var $price
 * @var $bid
 * @var $issued
 */
class MarketOrder extends AbstractActiveRecord
{
    const ORDER_STATE_OPEN = 0; // or active
    const ORDER_STATE_CLOSED = 1;
    const ORDER_STATE_EXPIRED = 2; // or fulfilled
    const ORDER_STATE_CANCELLED = 3;
    const ORDER_STATE_PENDING = 4;
    const ORDER_STATE_CHAR_DELETED = 5;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'api_characters_marketOrder';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }
}