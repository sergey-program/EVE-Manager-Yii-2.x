<?php

namespace app\modules\station\controllers;

use app\modules\station\controllers\_extend\StationController;
use app\modules\station\models\_search\SearchConquerableStation;
use app\modules\station\updaters\UpdaterEveConquerableStation;

class IndexController extends StationController
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
        $mSearchConquerableStation = new SearchConquerableStation();

        return $this->render('list', ['mSearchConquerableStation' => $mSearchConquerableStation]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionUpdate()
    {
        $sReturnUrl = $this->getGetData('updateStation');
        UpdaterEveConquerableStation::update();

        if ($sReturnUrl) {
            return $this->redirect($sReturnUrl);
        }

        return $this->redirect(['/station/index/index']);
    }
}