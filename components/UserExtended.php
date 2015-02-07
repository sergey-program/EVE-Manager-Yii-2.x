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
     * @param string $sRole
     *
     * @return mixed
     */
    public function hasRole($sRole)
    {
        return Yii::$app->authManager->checkAccess(Yii::$app->getUser()->getID(), $sRole);
    }

    /**
     * @return string|null
     */
    public function getUsername()
    {
        $sUsername = null;

        if (!$this->getIsGuest()) {
            $oUserIdentity = $this->getIdentity();
            
            if ($oUserIdentity) {
                $sUsername = $oUserIdentity->username;
            }
        }

        return $sUsername;
    }
}