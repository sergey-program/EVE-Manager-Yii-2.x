<?php

namespace app\controllers;

use app\controllers\_extend\AbstractController;
use app\models\ContactForm;

/**
 * Class ContactController
 *
 * @package app\controllers
 */
class ContactController extends AbstractController
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $model = new ContactForm();

        if ($model->load($this->getPostData()) && $model->contact(\Yii::$app->params['adminEmail'])) {
            \Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('index', ['model' => $model]);
        }
    }
}