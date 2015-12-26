<?php

namespace app\modules\prices\controllers;

use app\modules\prices\controllers\extend\AbstractPricesController;
use app\modules\prices\models\SearchPrice;
use app\modules\prices\updaters\UpdaterEveCentral;
use yii\helpers\Url;

/**
 * Class IndexController
 *
 * @package app\modules\prices\controllers
 */
class IndexController extends AbstractPricesController
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

        $searchPrice = new SearchPrice();

        return $this->render('list', ['searchPrice' => $searchPrice]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionUpdate()
    {
        UpdaterEveCentral::update();

        return $this->redirect(Url::previous(self::REMEMBER_NAME));
    }
}