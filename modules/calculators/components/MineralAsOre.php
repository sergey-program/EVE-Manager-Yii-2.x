<?php

namespace app\modules\calculators\components;

use app\models\CompressSettings;

/**
 * Class MineralAsOre
 *
 * @package app\modules\calculators\components
 */
class MineralAsOre
{
    /** @var CompressSettings[]|array $compressSettings */
    private $compressSettings = [];

    /**
     * MineralAsOre constructor.
     */
    public function __construct()
    {
        $this->compressSettings = CompressSettings::find()->where(['userID' => \Yii::$app->user->id])->orderBy(['order'=>'DESC'])->all();
    }

    /**
     * @param int $typeID
     *
     * @return \app\components\items\Item|null
     */
    public function getOreForMineral($typeID)
    {
        foreach ($this->compressSettings as $compressSetting) {
            if ($compressSetting->mineralTypeID == $typeID) {

                return $compressSetting->oreType ? $compressSetting->oreType->getItem() : null;
            }
        }

        return null;
    }
}