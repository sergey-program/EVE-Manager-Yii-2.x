<?php

namespace app\models\api\account;

use app\models\_extend\AbstractActiveRecord;
use app\models\Api;

/**
 * Class ApiKeyInfo
 *
 * @package app\models\api\account
 * @var $id
 * @var $apiID
 * @var $accessMask
 * @var $type
 * @var $expires
 */
class ApiKeyInfo extends AbstractActiveRecord
{
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
            ['accessMask', 'integer'],
            [['accessMask', 'type', 'expires'], 'safe']
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
    public function getApi()
    {
        return $this->hasOne(Api::className(), ['id' => 'apiID']);
    }
}