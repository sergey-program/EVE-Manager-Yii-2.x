<?php

namespace app\controllers;

use app\controllers\_extend\AbstractController;

class AboutController extends AbstractController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}