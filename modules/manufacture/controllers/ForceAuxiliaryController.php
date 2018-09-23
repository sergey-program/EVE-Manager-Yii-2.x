<?php

namespace app\modules\manufacture\controllers;

use app\models\dump\InvTypes;

class ForceAuxiliaryController extends AbstractManufactureController
{
    public function actionIndex()
    {
        $invTypes = InvTypes::find()->where(['groupID' => 1538])->all();

        return $this->render('index', ['invTypes' => $invTypes]);
    }
}