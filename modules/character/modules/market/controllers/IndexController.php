<?php

namespace app\modules\character\modules\market\controllers;

use app\modules\character\modules\market\controllers\_extend\MarketController;

class IndexController extends MarketController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->addBread(['label' => 'Index']);

        return $this->render('index');
    }
}