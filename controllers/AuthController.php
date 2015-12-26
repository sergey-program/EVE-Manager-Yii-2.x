<?php

namespace app\controllers;

use app\controllers\extend\AbstractController;
use app\forms\FormLogin;

/**
 * Class AuthController
 *
 * @package app\controllers
 */
class AuthController extends AbstractController
{
    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->getView()->setTitle('Login');

        $fLogin = new FormLogin();

        if ($fLogin->load($this->post()) && $fLogin->login()) {
            return $this->goBack();
        }

        return $this->render('login', ['fLogin' => $fLogin]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout(false);

        return $this->goHome();
    }
}