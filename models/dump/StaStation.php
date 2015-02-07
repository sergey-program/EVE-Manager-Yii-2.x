<?php

namespace app\models\dump;

use app\models\_extend\AbstractActiveRecord;

class StaStation extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '_dump_staStation';
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
}