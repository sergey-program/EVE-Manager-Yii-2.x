<?php

namespace app\modules\character\controllers;

use app\modules\character\controllers\_extend\CharacterController;

class IndexController extends CharacterController
{
    /**
     * @param int $characterID
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($characterID)
    {
        $mCharacter = $this->loadCharacter($characterID);
        $this
            ->addBread(['label' => 'Characters', 'url' => ['/characters/index/list']])
            ->addBread(['label' => $mCharacter->characterName]);

        return $this->render('index', ['mCharacter' => $mCharacter]);
    }
}