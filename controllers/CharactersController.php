<?php

namespace app\controllers;

use app\controllers\extend\AbstractController;
use app\models\api\account\Character;

/**
 * Class CharactersController
 *
 * @package app\modules\characters\controllers
 */
class CharactersController extends AbstractController
{
    public $defaultAction = 'list';
    public $layout = 'backend';

    public function init()
    {
        parent::init();
        $this->getView()->addBread(['label' => 'Characters', 'url' => ['/characters']]);
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $this->getView()->addBread('List');

        $characters = Character::find()
            ->joinWith('api')
            ->where(['api.userID' => \Yii::$app->user->id])
            ->all();

        return $this->render('list', ['characters' => $characters]);
    }
}