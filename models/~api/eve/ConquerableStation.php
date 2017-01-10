<?php

namespace app\models\api\eve;

use app\models\extend\AbstractActiveRecord;

/**
 * Class ConquerableStation
 *
 * @package app\models\api\characters
 *
 * @property int    $id
 * @property int    $stationID
 * @property string $stationName
 * @property int    $stationTypeID
 * @property int    $solarSystemID
 * @property int    $corporationID
 * @property string $corporationName
 * @property int    $timeUpdate
 */
class ConquerableStation extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'api_eve_conquerableStation';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['stationID', 'stationName'], 'required'],
            [['stationTypeID', 'solarSystemID', 'corporationID', 'corporationName', 'timeUpdate'], 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stationID' => 'Station ID',
            'solarSystemID' => 'Solar System ID'
        ];
    }

    ### relations

    ### functions
}