<?php

namespace app\modules\api\controllers;

use app\models\Api;
use app\modules\api\controllers\_extend\ApiController;
use app\modules\api\updaters\UpdaterAccountApi;

class IndexController extends ApiController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->addBread(['label' => 'Index']);

        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $this->addBread(['label' => 'List']);
        $aApi = Api::find()->all();

        return $this->render('list', ['aApi' => $aApi]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        $this->addBread(['label' => 'Add']);
        $mApi = new Api();

        if ($this->isPostRequest()) {
            if ($mApi->load($this->getPostData())) {
                if ($mApi->validate()) {
                    $mApi->save();

                    return $this->redirect(['/api/index/list']);
                }
            }
        }

        return $this->render('add', ['mApi' => $mApi]);
    }

    /**
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate()
    {
        UpdaterAccountApi::updateBy($this->mApi->id);
        $sReturnUrl = $this->getGetData('returnUrl');

        if ($sReturnUrl) {
            return $this->redirect($sReturnUrl);
        }

        return $this->redirect(['/api/index/list']);
    }

    /**
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDelete()
    {
        if ($this->mApi) {
            $this->mApi->delete();
        }

        return $this->redirect(['/api/index/list']);
    }
}