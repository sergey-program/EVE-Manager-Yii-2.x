<?php

namespace app\controllers;

use app\components\eve\ActionReprocess;
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
        $formCalculator = new FormCalculator();

        if (\Yii::$app->request->isPost && $formCalculator->load($this->post())) {
            $formCalculator->parse();
        }

        return $this->render('index', ['formCalculator' => $formCalculator]);
    }
}