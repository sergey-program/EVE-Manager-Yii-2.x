<?php

namespace app\modules\corporation\controllers;

use app\modules\corporation\controllers\extend\AbstractCorporationController;

/**
 * Class IndexController
 *
 * @package app\modules\corporation\controllers
 */
class IndexController extends AbstractCorporationController
{

    /**
     * @return string
     */
    public function actionInstall()
    {
        return $this->render('install');
    }

    public function actionInstallCallback()
    {
        $code = \Yii::$app->session->getFlash('code');

        //

    }
}