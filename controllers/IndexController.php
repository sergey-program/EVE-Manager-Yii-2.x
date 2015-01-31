<?php

namespace app\controllers;

use app\controllers\_extend\AbstractController;

class IndexController extends AbstractController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
