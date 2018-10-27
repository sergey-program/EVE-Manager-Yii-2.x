<?php

namespace app\models\dump;

use app\models\extend\AbstractActiveRecord;

/**
 * Class IndustryActivityMaterials
 *
 * @package app\models\dump
 *
 * @property int      $typeID
 * @property int      $activityID
 * @property int      $materialTypeID
 * @property int      $quantity
 *
 *
 * @property InvTypes $invType
 * @property InvTypes $materialInvType
 */
class IndustryActivityMaterials extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'industryActivityMaterials';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvType()
    {
        return $this->hasOne(InvTypes::class, ['typeID' => 'typeID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialInvType()
    {
        return $this->hasOne(InvTypes::class, ['typeID' => 'materialTypeID']);
    }
}