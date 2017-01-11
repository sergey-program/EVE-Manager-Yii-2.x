<?php

namespace app\models;

use app\models\extend\AbstractActiveRecord;

/**
 * Class UserToken
 *
 * @package app\models
 *
 * @property int    $id
 * @property int    $userID
 * @property string $accessToken
 * @property string $tokenType
 * @property int    $expiresIn
 * @property string $refreshToken
 * @property int    $timeCreate
 */
class UserToken extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_token}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['userID', 'required'],
            [['accessToken', 'tokenType', 'expiresIn', 'refreshToken', 'timeCreate'], 'safe'],
            ['timeCreate', 'default', 'value' => time()]
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
}