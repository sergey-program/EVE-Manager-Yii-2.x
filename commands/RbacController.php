<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;

/**
 * Class RbacController
 *
 * @package app\commands
 */
class RbacController extends Controller
{
    /**
     *
     */
    public function actionInit()
    {
        // assign roles
        $oAuthManager = \Yii::$app->authManager;
        $oAuthManager->removeAll();

        // role user
        $oRoleUser = $oAuthManager->createRole('user');
        $oRoleUser->description = 'Registered user';
        $oAuthManager->add($oRoleUser);

        // create default users
        $aDefaultUser = \Yii::$app->params['aDefaultUser'];
        $oSecurity = \Yii::$app->security;

        foreach ($aDefaultUser as $sUsername => $aUserData) {
            $mUser = User::findOne(['username' => $aUserData['username']]);

            if (!$mUser) {
                $mUser = new User();
                $mUser->username = $sUsername;
                $mUser->password = $oSecurity->generatePasswordHash($aUserData['password']);
                $mUser->email = $aUserData['email'];
                $mUser->authKey = $oSecurity->generateRandomString();
            }

            if ($mUser->validate()) {
                $mUser->save();
                // assign role to each
                $oAuthManager->assign($oAuthManager->getRole($aUserData['role']), $mUser->id);
            }
        }
    }
}