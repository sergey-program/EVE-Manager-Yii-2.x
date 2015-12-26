<?php

namespace app\modules\character\modules\market\controllers\extend;

use app\models\MarketDemand;
use app\modules\character\controllers\extend\AbstractCharacterController;
use yii\web\NotFoundHttpException;

/**
 * Class AbstractMarketController
 *
 * @package app\modules\character\modules\market\controllers\extend
 */
abstract class AbstractMarketController extends AbstractCharacterController
{
    const REMEMBER_NAME = 'character_market';

    public $layout = 'main';

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->getView();
//            ->addBread(['label' => $this->mCharacter->characterName, 'url' => ['/character/index/index', 'characterID' => $this->mCharacter->characterID]])
//            ->addBread(['label' => 'Market', 'url' => ['/character/market/index', 'characterID' => $this->mCharacter->characterID]]);
    }


    /**
     * @param int $id
     *
     * @return MarketDemand
     * @throws NotFoundHttpException
     */
    public function loadMarketDemand($id)
    {
        $model = MarketDemand::findOne(['id' => $id, 'userID' => \Yii::$app->user->id]);

        if (!$model) {
            throw new NotFoundHttpException ('Such market demand does not exist.');
        }

        return $model;
    }
}