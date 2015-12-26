<?php

namespace app\models;

use app\models\extend\AbstractActiveRecord;

/**
 * Class PriceCron
 *
 * @package app\models
 *
 * @property int $id
 * @property int $typeID
 * @property int $timeUpdated
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
            ['timeUpdated', 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID'
        ];
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