<?php

namespace app\modules\calculators\controllers;

use app\forms\FormCalculator;

/**
 * Class LootController
 *
 * @package app\modules\calculators\controllers
 */
class LootController extends AbstractCalculatorsController
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
     * @throws \Exception
     */
    public function actionUpdatePrices()
    {
        throw new \Exception('Not implemented yet.');
        // @todo should update all unupdated item prices
//        $updater = new MarketOrders();
//        $updater->getOrders()->updateDB();
//        return $this->redirect(['index']);
    }
}