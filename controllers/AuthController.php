<?php

namespace app\controllers;

use app\controllers\_extend\AbstractController;
use app\models\LoginForm;

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

        $model = new LoginForm();

        if ($model->load($this->getPostData()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', ['model' => $model]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }
}