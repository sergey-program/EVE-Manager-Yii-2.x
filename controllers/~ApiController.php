<?php

namespace app\controllers;

use app\controllers\extend\AbstractController;
use app\models\Api;
use yii\web\NotFoundHttpException;

/**
 * Class ApiController
 *
 * @package app\controllers
 */
class ApiController extends AbstractController
{
    public $defaultAction = 'list';
    public $layout = 'backend';

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->getView()->addBread(['label' => 'Api', 'url' => ['/api']]);
    }

    /**
     * @param int $apiID
     *
     * @return Api
     * @throws NotFoundHttpException
     */
    protected function loadApi($apiID)
    {
        /** @var Api $model */
        $model = Api::find()->where(['id' => $apiID, 'userID' => \Yii::$app->user->id])->one();

        if (!$model) {
            throw new NotFoundHttpException('Api not found.');
        }

        return $model;
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $this->getView()->addBread('List');
        $apis = Api::find()->where(['userID' => \Yii::$app->user->id])->all();

        return $this->render('list', ['apis' => $apis]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        $this->getView()->addBread('Add');

        $api = new Api();
        $api->userID = \Yii::$app->user->id;
        $api->timeCreated = time();

        if ($this->isPost() && $api->load($this->post())) {
            if ($api->save()) {
                return $this->redirect(['/api']);
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
        try {
            $api = $this->loadApi($apiID);
            $api
                ->updateApiKeyInfo()
                ->updateCharacters();
        } catch (\Exception $exception) {
            // do nothing
        }

        return $this->redirect(['/api']);
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

        return $this->redirect(['/api']);
    }
}