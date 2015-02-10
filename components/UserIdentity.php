<?php

namespace app\components;

use yii\web\IdentityInterface;
use app\models\User;
use yii\base\NotSupportedException;

class UserIdentity extends User implements IdentityInterface
{
    /**
     * @param int|string $sID
     *
     * @return IdentityInterface|static
     */
    public static function findIdentity($sID)
    {
        return static::findOne(['id' => $sID]);
    }

    /**
     * @param string      $sToken
     * @param string|null $sType
     *
     * @return void|IdentityInterface
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($sToken, $sType = null)
    {
        throw new NotSupportedException('<strong>findIdentityByAccessToken</strong> is not implemented.');
    }

    /**
     * @return int|mixed|string
     */
    public function getID()
    {
        return $this->getPrimaryKey();
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
     * @param string $sAuthKey
     *
     * @return bool
     */
    public function validateAuthKey($sAuthKey)
    {
        return $this->getAuthKey() === $sAuthKey;
    }
}