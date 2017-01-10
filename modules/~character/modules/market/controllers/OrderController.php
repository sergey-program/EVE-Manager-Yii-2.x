<?php

namespace app\modules\character\modules\market\controllers;

use app\calls\character\CallMarketOrders;
use app\modules\character\modules\market\controllers\extend\AbstractMarketController;
use app\modules\character\modules\market\models\SearchMarketOrder;
use app\modules\character\modules\market\updaters\UpdaterCharacterMarketOrder;

/**
 * Class OrderController
 *
 * @package app\modules\character\modules\market\controllers
 */
class OrderController extends AbstractMarketController
{
    /**
     * @param int $characterID
     *
     * @return string
     */
    public function actionIndex($characterID)
    {
        $character = $this->loadCharacter($characterID);

        $this
            ->getView()
            ->addBread(['label' => 'Orders', 'url' => ['order/index', 'characterID' => $character->characterID]])
            ->addBread(['label' => 'Index'])
            ->setCharacter($character);

        return $this->render('index');
    }

    /**
     * @param int $characterID
     *
     * @return string
     */
    public function actionList($characterID)
    {
        $character = $this->loadCharacter($characterID);
        $this
            ->getView()
            ->addBread(['label' => 'Orders', 'url' => ['order/index', 'characterID' => $character->characterID]])
            ->addBread(['label' => 'List'])
            ->setCharacter($character);

        $searchMarketOrder = new SearchMarketOrder();
        $searchMarketOrder->characterID = $character->characterID;

        return $this->render('list', ['searchMarketOrder' => $searchMarketOrder]);
    }

    /**
     * @param int $characterID
     *
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($characterID)
    {
        $character = $this->loadCharacter($characterID);

        $callMarketOrders = new CallMarketOrders();
        $callMarketOrders->keyID = $character->api->keyID;
        $callMarketOrders->vCode = $character->api->vCode;
        $callMarketOrders->characterID = $characterID;
        $callMarketOrders->update();

        return $this->redirect(['order/index', 'characterID' => $characterID]);
    }
}