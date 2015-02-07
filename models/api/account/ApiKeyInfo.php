<?php

namespace app\models\api\account;

use app\models\_extend\AbstractActiveRecord;

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