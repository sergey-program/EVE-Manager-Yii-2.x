<?php

namespace app\models;

use app\models\extend\AbstractActiveRecord;

/**
 * Class User
 *
 * @package app\models
 *
 * @property int       $id
 * @property string    $characterName
 * @property string    $characterID
 * @property string    $authKey
 * @property int       $timeCreate
 *
 * @property UserToken $token
 */
class User extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['authKey', 'default', 'value' => md5(time() + mt_rand(1, 1000))],
            ['authKey', 'required'],
            ['timeCreate', 'default', 'value' => time()],
            [['characterName', 'characterID', 'timeCreate'], 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'characterName' => 'Character name',
            'characterID' => 'Character ID',
            'authKey' => 'Auth. key',
            'timeCreate' => 'Time create'
        ];
    }

    ### relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToken()
    {
        return $this->hasOne(UserToken::className(), ['userID' => 'id']);
    }

    ### functions
}