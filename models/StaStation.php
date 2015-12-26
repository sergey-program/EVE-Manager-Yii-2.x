<?php

namespace app\models;

use app\models\extend\AbstractActiveRecord;

/**
 * Class StaStation
 * @package app\models
 *
 * @property $stationID
 * @property $security
 * @property $dockingCostPerVolume
 * @property $maxShipVolumeDockable
 * @property $officeRentalCost
 * @property $operationID
 * @property $stationTypeID
 * @property $corporationID
 * @property $solarSystemID
 * @property $constellationID
 * @property $regionID
 * @property $stationName
 * @property $x
 * @property $y
 * @property $z
 * @property $reprocessingEfficiency
 * @property $reprocessingStationsTake
 * @property $reprocessingHangarFlag
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