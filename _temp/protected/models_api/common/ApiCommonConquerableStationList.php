<?php

class ApiCommonConquerableStationList extends AbstractModel
{
    public $id;
    public $stationID;
    public $stationName;
    public $stationTypeID;
    public $solarSystemID;
    public $corporationID;
    public $corporationName;

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
        return 'api_common_conquerableStationList';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('stationID, stationName, stationTypeID, solarSystemID, corporationID, corporationName', 'required', 'on' => 'create')
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
        return array();
    }
}