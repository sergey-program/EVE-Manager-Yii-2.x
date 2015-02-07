<?php

class ApiCharacterMarketOrders extends AbstractModel
{
    const ORDER_STATE_OPEN = 0; // or active
    const ORDER_STATE_CLOSED = 1;
    const ORDER_STATE_EXPIRED = 2; // or fulfilled
    const ORDER_STATE_CANCELLED = 3;
    const ORDER_STATE_PENDING = 4;
    const ORDER_STATE_CHAR_DELETED = 5;

    public $id;
    public $characterID;
    public $orderID;
    public $stationID;
    public $volEntered;
    public $volRemaining;
    public $minVolume;
    public $orderState;
    public $typeID;
    public $range;
    public $accountKey;
    public $duration;
    public $escrow;
    public $price;
    public $bid;
    public $issued;

    /**
     * @param string $sClass
     *
     * @return CActiveRecord
     */
    public static function model($sClass = __CLASS__)
    {
        return parent::model($sClass);
    }

    /**
     * @return string
     */
    public function tableName()
    {
        return 'api_character_marketOrders';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('characterID, orderID, stationID, volEntered, volRemaining, minVolume, orderState, typeID, range, accountKey, duration, escrow, price, bid, issued', 'required', 'on' => 'create')
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array();
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'oInvTypes' => array(self::BELONGS_TO, 'InvTypes', 'typeID')
        );
    }
}
