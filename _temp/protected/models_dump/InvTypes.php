<?php

class InvTypes extends AbstractModel
{
    public $typeID;
    public $groupID;
    public $typeName;
    public $description;
    public $mass;
    public $volume;
    public $capacity;
    public $portionSize;
    public $raceID;
    public $basePrice;
    public $published;
    public $marketGroupID;
    public $chanceOfDuplicating;

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
        return 'dump_invTypes';
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