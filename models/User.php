<?php

namespace app\models;

use app\models\_extend\AbstractActiveRecord;

/**
 * Class User
 *
 * @package app\models
 *
 * @var $id         int
 * @var $username   string
 * @var $password   string
 * @var $email      string
 * @var $timeCreate int
 * @var $authKey    string
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
}