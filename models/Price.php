<?php

namespace app\models;

use app\models\extend\AbstractActiveRecord;

/**
 * Class Price
 *
 * @package app\models
 *
 * @property int      $id
 * @property int      $typeID
 * @property int      $type
 * @property int      $volume
 * @property float    $average
 * @property float    $max
 * @property float    $min
 * @property float    $stdDev
 * @property float    $median
 * @property float    $percentile
 *
 * @property InvTypes $invTypes
 */
class Price extends AbstractActiveRecord
{
    const TYPE_BUY = 1;
    const TYPE_SELL = 0;

    public static function tableName()
    {
        return 'api_price_item';
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
    public function getInvTypes()
    {
        return $this->hasOne(InvTypes::className(), ['typeID' => 'typeID']);
    }

    ### functions
}