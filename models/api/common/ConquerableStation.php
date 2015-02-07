<?php

namespace app\models\api\characters;

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
        return 'api_characters_conquerableStation';
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