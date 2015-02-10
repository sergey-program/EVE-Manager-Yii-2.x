<?php

namespace app\modules\prices\models;

use app\models\_extend\AbstractActiveRecord;

/**
 * Class PriceCron
 *
 * @package app\modules\prices\models
 *
 * @var $id
 * @var $typeID
 * @var $date
 */
class PriceCron extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'api_price_item_cron';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['typeID', 'required'],
            ['date', 'safe']
        ];
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
    public function getPrice()
    {
        return $this->hasOne(Price::className(), ['typeID' => 'typeID']);
    }

    ### functions
}