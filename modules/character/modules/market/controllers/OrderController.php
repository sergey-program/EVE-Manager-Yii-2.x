<?php

namespace app\modules\character\modules\market\controllers;

use app\calls\character\CallMarketOrders;
use app\modules\character\modules\market\models\_search\SearchMarketOrder;
use app\modules\character\modules\market\controllers\_extend\MarketController;

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
        $oCallMarketOrders = new CallMarketOrders();
        $oCallMarketOrders->keyID = $this->mCharacter->api->keyID;
        $oCallMarketOrders->vCode = $this->mCharacter->api->vCode;;
        $oCallMarketOrders->characterID = $this->mCharacter->characterID;

        $oCallMarketOrders->update();

        return $this->redirect(['/character/market/order/index', 'characterID' => $this->mCharacter->characterID]);
    }
}