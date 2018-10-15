<?php

namespace app\models;

use app\models\dump\InvTypes;
use app\models\extend\AbstractActiveRecord;

/**
 * Class CompressSettings
 *
 * @package app\models
 *
 * @property int      $id
 * @property int      $order
 * @property int      $mineralTypeID
 * @property int      $oreTypeID
 *
 * @property InvTypes $mineralType
 * @property InvTypes $oreType
 */
class CompressSettings extends AbstractActiveRecord
{
    public static function tableName()
    {
        return '{{%compress_settings}}';
    }

    public function rules()
    {
        return [];
    }

    public function attributeLabels()
    {
        return [];
    }

    ### relations

    public function getMineralType()
    {
        return $this->hasOne(InvTypes::class, ['typeID' => 'mineralTypeID']);
    }

    public function getOreType()
    {
        return $this->hasOne(InvTypes::class, ['typeID' => 'oreTypeID']);
    }

    ### functions
}