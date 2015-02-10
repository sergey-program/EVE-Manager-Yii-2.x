<?php

namespace app\modules\prices\models;

use app\models\_extend\AbstractActiveRecord;
use app\models\InvTypes;

/**
 * Class Price
 *
 * @package app\modules\prices\models
 *
 * @var $id
 * @var $typeID
 * @var $type
 * @var $date
 * @var $volume
 * @var $average
 * @var $max
 * @var $min
 * @var $stdDev
 * @var $median
 * @var $percentile
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