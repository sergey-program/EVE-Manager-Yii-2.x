<?php

namespace app\models\api\account;

use app\models\extend\AbstractActiveRecord;
use app\models\Api;

/**
 * Class ApiKeyInfo
 *
 * @package app\models\api\account
 *
 * @property int    $id
 * @property int    $apiID
 * @property int    $accessMask
 * @property string $type
 * @property int    $expires
 * @property int    $timeUpdated
 *
 * @property Api    $api
 */
class ApiKeyInfo extends AbstractActiveRecord
{
    const ACCESS_MASK_FULL = '268435455';

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'api_account_apiKeyInfo';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['apiID', 'required'],
            [['accessMask', 'type', 'expires', 'timeUpdated'], 'safe']
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
    public function getApi()
    {
        return $this->hasOne(Api::className(), ['id' => 'apiID']);
    }

    ### functions
}