<?php

namespace app\controllers;

use app\components\EveSSO;
use app\controllers\extend\AbstractController;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;

/**
 * Class CallbackController
 *
 * @package app\controllers
 */
class CallbackController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['detect'], 'roles' => ['?', '@']]
                ]
            ]
        ];
    }

    /**
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDetect()
    {
        \Yii::$app->session->setFlash('code', $this->get('code'));

        if (EveSSO::isAction(EveSSO::ACTION_SI)) {
            return $this->redirect(['/auth/sign-in-callback']);
        }

        if (EveSSO::isAction(EveSSO::ACTION_IC)) {
            return $this->redirect(['/corporation/install/index-callback']);
        }

        throw new BadRequestHttpException('Unknown action.');
    }
}