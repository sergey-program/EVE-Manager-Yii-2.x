<?php

namespace app\models;

use app\models\extend\AbstractActiveRecord;
use yii\web\ForbiddenHttpException;

/**
 * Class Corporation
 *
 * @package app\models
 *
 * @property int $id
 * @property int $corporationID
 * @property int $corporationName
 * @property int $characterID
 * @property int $characterName
 * @property int $timeCreate
 */
class Corporation extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%corporation}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['timeCreate', 'default', 'value' => time()],
            [['corporationID', 'corporationName', 'characterID', 'characterName', 'timeCreate'], 'safe']
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

    ### functions

    /**
     * Simple check was
     *
     * @param bool $exception
     *
     * @return bool
     * @throws ForbiddenHttpException
     */
    public static function checkCanInstall($exception = true)
    {
        $corporations = self::find()->all();
        // @todo add checker that token exist

        if (count($corporations) == 1) {
            if ($exception) {
                throw new ForbiddenHttpException('Corporation was already installed.');
            } else {
                return false;
            }
        }

        if (count($corporations) > 1) {
            if ($exception) {
                throw new ForbiddenHttpException('There was installed two corporation. Contact your admin.');
            } else {
                return false;
            }
        }

        return true;
    }
}