<?php

namespace app\modules\character\controllers;

use app\modules\character\controllers\_extend\CharacterController;

class IndexController extends CharacterController
{
    /**
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        $this
            ->addBread(['label' => 'Characters', 'url' => ['/characters/index/list']])
            ->addBread(['label' => $this->mCharacter->characterName]);

        return $this->render('index', ['mCharacter' => $this->mCharacter]);
    }
}