<?php

namespace app\controllers;

use app\components\updater\MarketOrders;
use app\controllers\extend\AbstractController;
use app\forms\FormCalculator;

/**
 * Class CalculatorController
 *
 * @package app\controllers
 */
class CalculatorController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $this
            ->getView()
            ->setPageTitle('Loot calculator')
            ->addBread('Other')
            ->addBread('Calculator');

        $formCalculator = new FormCalculator();

        if (\Yii::$app->request->isPost && $formCalculator->load($this->post())) {
            $formCalculator->parse();
        }

        return $this->render('index', ['formCalculator' => $formCalculator]);
    }

    /**
     * Temp action for price update. Remove after cron setuped.
     *
     * @return \yii\web\Response
     */
    public function actionUpdatePrices()
    {
        $updater = new MarketOrders();
        $updater->getOrders()->updateDB();

        return $this->redirect(['index']);
    }
}