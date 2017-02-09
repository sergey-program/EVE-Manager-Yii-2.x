<?php

namespace app\models;

use app\models\extend\AbstractActiveRecord;

/**
 * Class User
 *
 * @package app\models
 *
 * @property int         $id
 * @property string      $characterName
 * @property string      $characterID
 * @property string      $authKey
 * @property int         $timeCreate
 * @property string|null $altGroup
 *
 * @property UserToken   $token
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
            ['altGroup', 'default', 'value' => md5(time() . mt_rand(0, 1000))],
            ['timeCreate', 'default', 'value' => time()],
            [['authKey', 'altGroup'], 'required'],
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
            'timeCreate' => 'Time create',
            'altGroup' => 'Character grouping'
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