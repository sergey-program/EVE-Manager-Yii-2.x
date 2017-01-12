<?php

namespace app\models;

use app\models\extend\AbstractAccessToken;

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
 * @property int    $timeUpdate
 *
 * @property User   $user
 */
class UserToken extends AbstractAccessToken
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
            [['accessToken', 'tokenType', 'expiresIn', 'refreshToken', 'timeCreate'], 'safe']
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userID']);
    }

    ### functions
}