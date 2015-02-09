<?php

namespace app\models;

use app\models\_extend\AbstractActiveRecord;

/**
 * Class InvTypes
 *
 * @package app\models
 *
 * @var $typeID
 * @var $groupID
 * @var $typeName
 * @var $description
 * @var $mass
 * @var $volume
 * @var $capacity
 * @var $portionSize
 * @var $raceID
 * @var $basePrice
 * @var $published
 * @var $marketGroupID
 * @var $chanceOfDuplicating
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