<?php

namespace app\modules\character\modules\market\controllers\_extend;

use app\models\MarketDemand;
use app\modules\character\controllers\_extend\CharacterController;
use yii\web\NotFoundHttpException;

abstract class MarketController extends CharacterController
{
    public $layout = 'main';

    /**
     *
     */
    public function init()
    {
        parent::init();
        $this->addBread(['label' => 'Characters', 'url' => ['/characters/index/list']]);
        $this->addBread(['label' => $this->mCharacter->characterName, 'url' => ['/character/index/index', 'characterID' => $this->mCharacter->characterID]]);
        $this->addBread(['label' => 'Market', 'url' => ['/character/market/index', 'characterID' => $this->mCharacter->characterID]]);
    }


    /**
     * @param int  $id
     * @param bool $bException
     *
     * @return static
     * @throws NotFoundHttpException
     */
    public function loadMarketDemand($id, $bException = true)
    {
        $mMarketDemand = MarketDemand::findOne(['id' => $id]);

        if (!$mMarketDemand && $bException) {
            throw new NotFoundHttpException ('Such market demand does not exist.');
        }

        return $mMarketDemand;
    }
}