<?php

namespace app\modules\character\modules\market\controllers;

use app\modules\character\modules\market\models\_search\SearchMarketOrder;
use app\modules\character\modules\market\controllers\_extend\MarketController;
use app\modules\character\modules\market\updaters\UpdaterCharacterMarketOrder;

class OrderController extends MarketController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $this
            ->addBread(['label' => 'Orders', 'url' => ['/character/market/order/index', 'characterID' => $this->mCharacter->characterID]])
            ->addBread(['label' => 'Index']);

        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $this
            ->addBread(['label' => 'Orders', 'url' => ['/character/market/order/index', 'characterID' => $this->mCharacter->characterID]])
            ->addBread(['label' => 'List']);

        $mSearchMarketOrder = new SearchMarketOrder();
        $mSearchMarketOrder->characterID = $this->mCharacter->characterID;

        return $this->render('list', ['mSearchMarketOrder' => $mSearchMarketOrder]);
    }

    /**
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate()
    {
        UpdaterCharacterMarketOrder::update($this->mCharacter->api->keyID, $this->mCharacter->api->vCode, $this->mCharacter->characterID);

        return $this->redirect(['/character/market/order/index', 'characterID' => $this->mCharacter->characterID]);
    }
}