<?php

namespace app\models\api\eve;

use app\models\_extend\AbstractActiveRecord;

/**
 * Class ConquerableStation
 *
 * @package app\models\api\characters
 * @var $id
 * @var $stationID
 * @var $stationName
 * @var $stationTypeID
 * @var $solarSystemID
 * @var $corporationID
 * @var $corporationName
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
            [['stationTypeID', 'solarSystemID', 'corporationID', 'corporationName'], 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }
}