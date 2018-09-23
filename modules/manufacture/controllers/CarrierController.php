<?php

namespace app\modules\manufacture\controllers;

use app\models\dump\InvTypes;

class CarrierController extends AbstractManufactureController
{
    public function actionIndex()
    {
        $invTypes = InvTypes::find()->where(['groupID' => 547])->all();

        return $this->render('index', ['invTypes' => $invTypes]);
    }
}