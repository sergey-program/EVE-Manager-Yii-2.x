<?php

namespace app\components;

use app\models\User;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * Class UserIdentity
 *
 * @package app\components
 */
class UserIdentity extends User implements IdentityInterface
{
    /**
     * @param int|string $id
     *
     * @return IdentityInterface|static
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @param string      $token
     * @param string|null $type
     *
     * @return void|IdentityInterface
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('<strong>findIdentityByAccessToken</strong> is not implemented.');
    }

    /**
     * @return int|mixed|string
     */
    public function getID()
    {
        return $this->primaryKey;
    }

    /**
     * This model extends User. $this->authKey is saved in db on registration.
     *
     * @return string
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @param string $authKey
     *
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}