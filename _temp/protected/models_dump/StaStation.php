<?php

class StaStation extends AbstractModel
{
    public $stationID;
    public $security;
    public $dockingCostPerVolume;
    public $maxShipVolumeDockable;
    public $officeRentalCost;
    public $operationID;
    public $stationTypeID;
    public $corporationID;
    public $solarSystemID;
    public $constellationID;
    public $regionID;
    public $stationName;
    public $x;
    public $y;
    public $z;
    public $reprocessingEfficiency;
    public $reprocessingStationsTake;
    public $reprocessingHangarFlag;

    /**
     * @param string $sClass
     *
     * @return mixed
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
        return 'dump_staStations';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array();
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