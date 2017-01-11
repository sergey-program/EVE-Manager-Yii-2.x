<?php

namespace app\modules\corporation\controllers;

use app\modules\corporation\controllers\extend\AbstractCorporationController;

/**
 * Class ApiController
 *
 * @package app\modules\corporation\controllers
 */
class ApiController extends AbstractCorporationController
{
    public function actionAdd()
    {
        return $this->render('add');
    }
}