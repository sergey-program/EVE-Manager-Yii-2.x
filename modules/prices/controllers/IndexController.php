<?php

namespace app\modules\prices\controllers;

use app\components\eveCentral\EveCentral;
use app\modules\prices\controllers\_extend\PricesController;
use app\modules\prices\models\_search\SearchPrice;
use app\modules\prices\updaters\UpdaterEveCentral;

class IndexController extends PricesController
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
        $mSearchPrice = new SearchPrice();

        return $this->render('list', ['mSearchPrice' => $mSearchPrice]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionUpdate()
    {
        $sReturnUrl = $this->getGetData('returnUrl');

        UpdaterEveCentral::update();

        if ($sReturnUrl) {
            return $this->redirect($sReturnUrl);
        }

        return $this->redirect(['/prices/index/index']);
    }
}