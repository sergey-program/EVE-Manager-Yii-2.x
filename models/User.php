<?php

namespace app\models;

use app\models\_extend\AbstractActiveRecord;

/**
 * Class User
 *
 * @package app\models
 *
 * @property int    $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property int    $timeCreate
 * @property string $authKey
 */
class User extends AbstractActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DISABLED = 'disabled';

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email', 'authKey'], 'required'],
            ['email', 'email']
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

    ### functions
}