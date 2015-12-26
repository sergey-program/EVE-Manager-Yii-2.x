<?php

namespace app\modules\api\controllers;

use app\modules\api\controllers\extend\AbstractApiController;
use app\models\Api;
use yii\helpers\Url;

/**
 * Class IndexController
 *
 * @package app\modules\api\controllers
 */
class IndexController extends AbstractApiController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        Url::remember(Url::current(), self::REMEMBER_NAME);
        $this->getView()->addBread('Index');

        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionList()
    {
        Url::remember(Url::current(), self::REMEMBER_NAME);
        $this->getView()->addBread('List');

        $apis = Api::find()->where(['userID' => \Yii::$app->user->id])->all();

        return $this->render('list', ['apis' => $apis]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        Url::remember(Url::current(), self::REMEMBER_NAME);
        $this->getView()->addBread('Add');

        $api = new Api();
        $api->userID = \Yii::$app->user->id;
        $api->timeCreated = time();

        if ($this->isPost() && $api->load($this->post())) {
            if ($api->save()) {
                return $this->redirect(['index/list']);
            }
        }

        return $this->render('add', ['api' => $api]);
    }

    /**
     * @param int $apiID
     *
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($apiID)
    {
        $api = $this->loadApi($apiID);
        $api
            ->updateApiKeyInfo()
            ->updateCharacters();

        return $this->redirect(Url::previous(self::REMEMBER_NAME));
    }

    /**
     * @param int $apiID
     *
     * @return \yii\web\Response
     */
    public function actionDelete($apiID)
    {
        try {
            $api = $this->loadApi($apiID);
            $api->delete();
        } catch (\Exception $exception) {
            // do nothing
        }

        return $this->redirect(Url::previous(self::REMEMBER_NAME));
    }
}