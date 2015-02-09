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
        if ($this->getGetData('updateStation')) {
            UpdaterEveConquerableStation::update();

            return $this->redirect(['/station/index/index']);
        }

        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $mSearchConquerableStation = new SearchConquerableStation();

        return $this->render('list', ['mSearchConquerableStation' => $mSearchConquerableStation]);
    }
}