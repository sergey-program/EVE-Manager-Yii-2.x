<?php

namespace app\modules\characters\controllers;

use app\models\api\account\Character;
use app\modules\characters\controllers\_extend\CharactersController;

class IndexController extends CharactersController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $aCharacter = Character::find()->all();

        return $this->render('list', ['aCharacter' => $aCharacter]);
    }
}