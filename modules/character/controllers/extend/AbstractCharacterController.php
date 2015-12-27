<?php

namespace app\modules\character\controllers\extend;

use app\controllers\extend\AbstractController;
use app\models\api\account\Character;
use yii\web\NotFoundHttpException;

/**
 * Class AbstractCharacterController
 *
 * @package app\modules\character\controllers\extend
 */
abstract class AbstractCharacterController extends AbstractController
{
    const REMEMBER_NAME = 'character';

    public $layout = 'main';

    /**
     * Search characterID and load model to view class.
     */
    public function init()
    {
        parent::init();

        if ($this->get('characterID', false)) {
            $character = $this->loadCharacter($this->get('characterID'));
            $this->getView()->setCharacter($character);
        }

        $this->getView()->addBread([
            'label' => 'Characters',
            'url' => ['/characters/index/list']
        ]);
    }

    /**
     * Simple wrapper to get from view class, loaded on init method.
     *
     * @return Character|null
     */
    protected function getCharacter()
    {
        return $this->getView()->getCharacter();
    }

    /**
     * @param int $id
     *
     * @return Character
     * @throws NotFoundHttpException
     */
    public function loadCharacter($id)
    {
        /** @var Character $character */
        $model = Character::find()
            ->joinWith('api')
            ->where(['api_account_characters.characterID' => $id, 'api.userID' => \Yii::$app->user->id])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('Such character does not exist.');
        }

        return $model;
    }
}