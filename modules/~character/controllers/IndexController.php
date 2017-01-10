<?php

namespace app\modules\character\controllers;

use app\modules\character\controllers\extend\AbstractCharacterController;

/**
 * Class IndexController
 *
 * @package app\modules\character\controllers
 */
class IndexController extends AbstractCharacterController
{
    /**
     * @param int $characterID
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($characterID)
    {
        $this->getView()->addBread(['label' => $this->getCharacter()->characterName]);

        return $this->render('index');
    }


}