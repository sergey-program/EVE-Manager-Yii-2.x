<?php

namespace app\modules\character\controllers;

use app\modules\character\controllers\_extend\CharacterController;

class IndexController extends CharacterController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList()
    {
        //$this->render('list', array('aCharacter' => clCharacter::loadAll()));
        return $this->render('list');
    }
}