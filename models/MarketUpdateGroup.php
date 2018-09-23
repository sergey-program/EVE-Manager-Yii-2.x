<?php

namespace app\models;

use app\models\extend\AbstractActiveRecord;

/**
 * Class MarketUpdateGroup
 *
 * @package app\models
 *
 * @property int $id
 * @property int $groupID
 * @property int $timeUpdate
 */
class MarketUpdateGroup extends AbstractActiveRecord
{
    public static function tableName()
    {
        return '{{%market_update_group}}';
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

    ### functions
}

