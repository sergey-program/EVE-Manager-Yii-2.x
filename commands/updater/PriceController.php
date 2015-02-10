<?php

namespace app\commands\updater;

use app\modules\prices\updaters\UpdaterEveCentral;
use yii\console\Controller;

class PriceController extends Controller
{
    /**
     *
     */
    public function actionUpdate()
    {
        UpdaterEveCentral::update(false);
    }
}