<?php

namespace app\models;

use app\models\extend\AbstractActiveRecord;

/**
 * Class User
 *
 * @package app\models
 *
 * @property int    $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $authKey
 * @property int    $timeCreate
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
            [['username', 'password', 'authKey'], 'required'],
            ['email', 'safe'],
            ['email', 'email']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth. key',
            'timeCreate' => 'Time create'
        ];
    }

    ### relations

    ### functions
}