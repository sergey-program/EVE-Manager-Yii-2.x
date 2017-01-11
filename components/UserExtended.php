<?php

namespace app\components;

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
        return \Yii::$app->authManager->checkAccess(\Yii::$app->user->id, $role);
    }

    /**
     * @return string|null
     */
    public function getCharacterName()
    {
        if (!$this->isGuest) {
            /** @var UserIdentity $userIdentity */
            $userIdentity = $this->getIdentity();

            if ($userIdentity) {
                return $userIdentity->characterName;
            }
        }

        return null;
    }
}