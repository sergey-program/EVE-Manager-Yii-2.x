<?php

namespace app\models;

use app\models\extend\AbstractActiveRecord;

/**
 * Class InvTypes
 *
 * @package app\models
 *
 * @property $typeID
 * @property $groupID
 * @property $typeName
 * @property $description
 * @property $mass
 * @property $volume
 * @property $capacity
 * @property $portionSize
 * @property $raceID
 * @property $basePrice
 * @property $published
 * @property $marketGroupID
 * @property $chanceOfDuplicating
 */
class InvTypes extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'invTypes';
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