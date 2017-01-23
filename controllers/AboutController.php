<?php

namespace app\controllers;

use app\controllers\extend\AbstractController;

/**
 * Class AboutController
 *
 * @package app\controllers
 */
class AboutController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->getView()->setPageTitle('About');

        return $this->render('index');
    }
}