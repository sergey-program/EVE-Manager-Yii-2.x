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

        $this->getView()
            ->addBread([
                'label' => $this->getCharacter()->characterName,
                'url' => ['/character/index/index', 'characterID' => $this->getCharacter()->characterID]
            ])
            ->addBread([
                'label' => 'Market',
                'url' => ['/character/market/index', 'characterID' => $this->getCharacter()->characterID]
            ]);
    }


    /**
     * @param int $demandID
     *
     * @return MarketDemand
     * @throws NotFoundHttpException
     */
    public function loadMarketDemand($demandID)
    {
        $model = MarketDemand::findOne(['id' => $demandID, 'userID' => \Yii::$app->user->id]);

        if (!$model) {
            throw new NotFoundHttpException ('Such market demand does not exist.');
        }

        return $model;
    }
}