<?php

namespace app\controllers;

use app\controllers\extend\AbstractController;
use app\forms\FormCalculatorPlanetology;
use app\models\dump\InvTypes;

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
    public function actionPlanetology()
    {
        $formCalculatorPlanetology = new FormCalculatorPlanetology();
        $items = [];

        if (\Yii::$app->request->isPost && $formCalculatorPlanetology->load($this->post())) {
            $items = $formCalculatorPlanetology->parse();
        }

        return $this->render('planetology', [
            'formCalculatorPlanetology' => $formCalculatorPlanetology,
            'items' => $items
        ]);
    }
}