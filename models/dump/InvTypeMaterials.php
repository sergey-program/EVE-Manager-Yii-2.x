<?php

namespace app\models\dump;

use app\models\extend\AbstractActiveRecord;

/**
 * Class InvTypeMaterials
 *
 * @package app\models\dump
 *
 * @property int      $typeID
 * @property int      $materialTypeID
 * @property int      $quantity
 *
 * @property InvTypes $invType
 * @property InvTypes $materialInvType
 */
class InvTypeMaterials extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'invTypeMaterials';
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvType()
    {
        return $this->hasOne(InvTypes::className(), ['typeID' => 'typeID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialInvType()
    {
        return $this->hasOne(InvTypes::className(), ['typeID' => 'materialTypeID']);
    }

    ### functions
}