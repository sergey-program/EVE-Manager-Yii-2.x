<?php

namespace app\commands\updater;

use app\models\Api;
use app\modules\api\updaters\UpdaterAccountApi;
use yii\console\Controller;

class ApiController extends Controller
{
    /**
     *
     */
    public function actionUpdate()
    {
        $aApi = Api::find()->all();

        foreach ($aApi as $mApi) {
            UpdaterAccountApi::update($mApi);
        }
    }
}