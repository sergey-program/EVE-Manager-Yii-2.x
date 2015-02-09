<?php

namespace app\modules\character\controllers;

use app\calls\character\CallMarketOrders;
use app\modules\character\models\_search\SearchMarketOrder;
use app\modules\character\controllers\_extend\CharacterController;

class MarketOrdersController extends CharacterController
{
    /**
     * @param int $characterID
     *
     * @return string
     */
    public function actionIndex($characterID)
    {
        $this->addBread(['label' => 'Market Orders']);
        $mCharacter = $this->loadCharacter($characterID);

        return $this->render('index', ['mCharacter' => $mCharacter]);
    }


    public function actionUpdate($characterID)
    {
        $mCharacter = $this->loadCharacter($characterID);

        $oCallMarketOrders = new CallMarketOrders();
        $oCallMarketOrders->keyID = $mCharacter->api->keyID;
        $oCallMarketOrders->vCode = $mCharacter->api->vCode;;
        $oCallMarketOrders->characterID = $mCharacter->characterID;

        $oCallMarketOrders->update();

        return $this->redirect(['/character/market-orders/index', 'characterID' => $characterID]);
    }

    /**
     * @param int $characterID
     *
     * @return string
     */
    public function actionList($characterID)
    {
        $mCharacter = $this->loadCharacter($characterID);
        $this->addBread(['label' => 'Market Orders'])->addBread(['label' => 'List']);

        $mSearchMarketOrder = new SearchMarketOrder();
        $mSearchMarketOrder->characterID = $characterID;

        return $this->render('list', ['mCharacter' => $mCharacter, 'mSearchMarketOrder' => $mSearchMarketOrder]);
    }
}