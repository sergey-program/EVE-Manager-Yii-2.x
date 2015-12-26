<?php

namespace app\components;

use Yii;
use yii\web\User;

/**
 * Class UserExtended
 *
 * @package app\components
 */
class UserExtended extends User
{
    /**
     * @param string $role
     *
     * @return mixed
     */
    public function hasRole($role)
    {
        return Yii::$app->authManager->checkAccess(Yii::$app->user->id, $role);
    }

    /**
     * @return string|null
     */
    public function getUsername()
    {
        $username = null;

        if (!$this->isGuest) {
            /** @var UserIdentity $userIdentity */
            $userIdentity = $this->getIdentity();

            if ($userIdentity) {
                $username = $userIdentity->username;
            }
        }

        return $username;
    }
}