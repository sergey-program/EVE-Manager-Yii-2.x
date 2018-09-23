<?php

namespace app\modules\manufacture\controllers;

use app\models\dump\InvTypes;

class DreadnoughtController extends AbstractManufactureController
{
    public function actionIndex()
    {
        $invTypes = InvTypes::find()->where(['groupID' => 485])->all();

        return $this->render('index', ['invTypes' => $invTypes]);
    }
}