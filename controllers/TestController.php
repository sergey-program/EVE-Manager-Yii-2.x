<?php

namespace app\controllers;

use app\controllers\extend\AbstractController;

/**
 * Class TestController
 *
 * @package app\controllers
 */
class TestController extends AbstractController
{
    /**
     *
     */
    public function actionIndex()
    {
        echo 'use some code for tests.';
    }
}