<?php

namespace app\modules\api\controllers;

use app\calls\account\CallApiKeyInfo;
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
        $oUpdater = new CallApiKeyInfo();
        $oUpdater->keyID = 3764904;
        $oUpdater->vCode = 'ZpcbvBFFNGm6BLVHkGTdaM2HdWIQuVpeZsap3msVLkad7tc76SKYfImdPqK9qcua';
        $oUpdater->update();

        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $this
            ->setTitle('Api List')
            ->addBread(['label' => 'List']);

        $aApi = Api::find()->all();
        $iApiID = $this->getGetData('updateApi');

        if ($iApiID) {
            UpdaterAccountApi::updateBy($iApiID);

            return $this->redirect(['/api/index/list']);
        }

        return $this->render('list', ['aApi' => $aApi]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        $this
            ->setTitle('Add new Api')
            ->addBread(['label' => 'Add']);

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
     * @param string|int $sApiID
     */
    public function actionUpdate($sApiID)
    {
//        $oApi = Api::model()->findByPk($sApiID);
//
//        if ($oApi) {
//            $oCallChar = new CallAccountCharacters();
//            $oCallChar
//                ->getStorage()
//                ->setVar('keyID', $oApi->keyID, cCallStorage::ALIAS_URL)
//                ->setVar('vCode', $oApi->vCode, cCallStorage::ALIAS_URL)
//                ->setVar('apiID', $oApi->id);
//
//            $oCallInfo = new CallAccountApiKeyInfo();
//            $oCallInfo
//                ->getStorage()
//                ->setVar('keyID', $oApi->keyID, cCallStorage::ALIAS_URL)
//                ->setVar('vCode', $oApi->vCode, cCallStorage::ALIAS_URL)
//                ->setVar('apiID', $oApi->id);
//
//            $oExecutor = new cCallExecutor();
//            $oExecutor
//                ->addCall($oCallChar)
//                ->addCall($oCallInfo)
//                ->doFetch()
//                ->doParse()
//                ->doUpdate();
//
//            $this->setFlash('success', 'Api #' . $oApi->id . ' was updated.');
//        } else {
//            $this->setFlash('danger', 'Such api doesn\'t exist.');
//        }
//
//        $this->redirect($this->createUrl('api/list'));
    }

    /**
     * @param int $id
     *
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        $mApi = Api::findOne(['id' => $id]);

        if ($mApi) {
            $mApi->delete();
        }

        return $this->redirect(['/api/index/list']);
    }
}