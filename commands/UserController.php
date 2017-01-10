<?php

namespace app\commands;

use app\models\User;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class UserController
 *
 * Simple creating new user.
 *
 * @package app\commands
 */
class UserController extends Controller
{
    /**
     * @param $username string
     * @param $password string
     */
    public function actionCreate($username, $password)
    {
        if (!$username) {
            $this->stdout('No username presented.', Console::BG_RED);
            die();
        }

        if (!$password) {
            $this->stdout('No password presented.', Console::BG_RED);
            die();
        }

        $user = User::findOne(['username' => $username]);

        if ($user) {
            $this->stdout('User exists. Changing password...');
        } else {
            $this->stdout('User does not exist. Creating...');
            $user = new User();
            $user->username = $username;
            $user->email = 'some@mail.ru';
            $user->authKey = \Yii::$app->security->generateRandomString();
        }

        $user->password = \Yii::$app->security->generatePasswordHash($password);

        if ($user->save()) {
            $this->stdout('User created.', Console::BG_GREEN);
            $am = \Yii::$app->authManager;
            $am->assign($am->getRole('user'), $user->id);
            $this->stdout('Roles assigned.', Console::BG_GREEN);
        } else {
            $this->stdout('User was not created.', Console::BG_RED);
        }
    }
}