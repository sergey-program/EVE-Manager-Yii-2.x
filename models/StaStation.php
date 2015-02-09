<?php

namespace app\models;

use app\models\_extend\AbstractActiveRecord;

/**
 * Class StaStation
 * @package app\models
 *
 * @var $stationID
 * @var $security
 * @var $dockingCostPerVolume
 * @var $maxShipVolumeDockable
 * @var $officeRentalCost
 * @var $operationID
 * @var $stationTypeID
 * @var $corporationID
 * @var $solarSystemID
 * @var $constellationID
 * @var $regionID
 * @var $stationName
 * @var $x
 * @var $y
 * @var $z
 * @var $reprocessingEfficiency
 * @var $reprocessingStationsTake
 * @var $reprocessingHangarFlag
 */
class StaStation extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'staStations';
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

    ### relations

    ### functions
}