<?php

namespace app\modules\characters\controllers;

use app\modules\characters\controllers\extend\AbstractCharactersController;
use app\models\api\account\Character;
use yii\helpers\Url;

/**
 * Class IndexController
 *
 * @package app\modules\characters\controllers
 */
class IndexController extends AbstractCharactersController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        Url::remember(Url::current(), self::REMEMBER_NAME);
        $this->getView()->addBread('Index');

        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionList()
    {
        Url::remember(Url::current(), self::REMEMBER_NAME);
        $this->getView()->addBread('List');

        $characters = Character::find()->joinWith('api')->where(['api.userID' => \Yii::$app->user->id])->all();

        return $this->render('list', ['characters' => $characters]);
    }
}