<?php

class MarketDemand extends AbstractModel
{
    const TYPE_SELL = 'sell';
    const TYPE_BUY = 'buy';

    public $id;
    public $characterID;
    public $stationID;
    public $typeID;
    public $quantity;
    public $demandType;

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
        return '{{market_demand}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('characterID, stationID, typeID, quantity, demandType', 'required', 'on' => 'create')
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
            'oInvTypes' => array(self::BELONGS_TO, 'InvTypes', array('typeID' => 'typeID'))
        );
    }
}