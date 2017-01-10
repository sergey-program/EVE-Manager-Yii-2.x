<?php

namespace app\modules\character\modules\market\controllers;

use app\modules\character\modules\market\controllers\extend\AbstractMarketController;
use app\models\MarketDemand;
use app\modules\prices\updaters\UpdaterEveCentral;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * Class DemandController
 *
 * @package app\modules\character\modules\market\controllers
 */
class DemandController extends AbstractMarketController
{
    /**
     * @param int $characterID
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($characterID)
    {
        Url::remember(Url::current(), self::REMEMBER_NAME);
        $character = $this->loadCharacter($characterID);

        $this
            ->getView()
            ->addBread(['label' => 'Demands', 'url' => ['demand/index', 'characterID' => $characterID]])
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
        Url::remember(Url::current(), self::REMEMBER_NAME);
        $character = $this->loadCharacter($characterID);

        $this
            ->getView()
            ->addBread(['label' => 'Demands', 'url' => ['demand/index', 'characterID' => $characterID]])
            ->addBread(['label' => 'List'])
            ->setCharacter($character);

        $marketDemands = MarketDemand::findAll([
            'characterID' => $characterID,
            'userID' => \Yii::$app->user->id
        ]);

        return $this->render('list', ['marketDemands' => $marketDemands]);
    }

    /**
     * @param int $characterID
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCreate($characterID)
    {
        Url::remember(Url::current(), self::REMEMBER_NAME);
        $character = $this->loadCharacter($characterID);

        $this
            ->getView()
            ->addBread(['label' => 'Demands', 'url' => ['demand/index', 'characterID' => $characterID]])
            ->addBread(['label' => 'Create'])
            ->setCharacter($character);

        $marketDemand = new MarketDemand();
        $marketDemand->characterID = $characterID;
        $marketDemand->userID = \Yii::$app->user->id;

        if ($this->isAjax()) {
            $type = $this->get('sType');

            if ($type == 'station') {
                $sql = '(SELECT sStation.stationID, sStation.stationName, sStation.stationTypeID FROM staStations as sStation WHERE sStation.stationName LIKE "%' . $_GET['q'] . '%")
                        UNION
                        (SELECT cStation.stationID, cStation.stationName, cStation.stationTypeID FROM api_eve_conquerableStation as cStation WHERE cStation.stationName LIKE "%' . $_GET['q'] . '%")';
            } elseif ($type == 'item') {
                $sql = 'SELECT typeID, typeName FROM invTypes WHERE typeName LIKE "%' . $_GET['q'] . '%" AND published ="1" ORDER BY typeName';
            }

            $return = \Yii::$app->db->createCommand($sql)->queryAll();

            echo Json::encode($return); // @todo change response type
            \Yii::$app->end();
        } elseif ($this->isPost() && $marketDemand->load($this->post())) {

            if ($marketDemand->save()) {
                UpdaterEveCentral::addType($marketDemand->typeID);

                return $this->redirect(['demand/list', 'characterID' => $characterID]);
            }
        }

        return $this->render('create', ['marketDemand' => $marketDemand]);
    }

    /**
     * @param int $id
     *
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete($id)
    {
        try {
            $marketDemand = $this->loadMarketDemand($id);
            $marketDemand->delete();
        } catch (\Exception $exception) {
            // do nothing
        }

        return $this->redirect(Url::previous(self::REMEMBER_NAME));
    }
}

