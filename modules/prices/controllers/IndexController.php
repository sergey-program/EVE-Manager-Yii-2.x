<?php

namespace app\modules\prices\controllers;

use app\components\eveCentral\EveCentral;
use app\modules\prices\controllers\_extend\PricesController;
use app\modules\prices\models\_search\SearchPrice;

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
        $oEveCentral = new EveCentral();
        $oEveCentral->addTypeID(mt_rand(100, 10000));
        $oEveCentral->fetch();

        return $this->render('list', ['mSearchPrice' => $mSearchPrice]);
    }
}