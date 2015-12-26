<?php

namespace app\controllers;

use app\controllers\extend\AbstractController;

/**
 * Class IndexController
 *
 * @package app\controllers
 */
class IndexController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->getView()->setTitle('Index');

        return $this->render('index');
    }
}
