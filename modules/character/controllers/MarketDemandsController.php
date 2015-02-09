<?php
namespace app\modules\character\controllers;

use app\models\MarketDemand;
use app\modules\character\controllers\_extend\CharacterController;
use yii\helpers\Json;

class MarketDemandsController extends CharacterController
{
    /**
     * @param int $characterID
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($characterID)
    {
        $mCharacter = $this->loadCharacter($characterID);

        return $this->render('index', ['mCharacter' => $mCharacter]);
    }

    /**
     * @param int $characterID
     *
     * @return string
     */
    public function actionList($characterID)
    {
        $mCharacter = $this->loadCharacter($characterID);
        $aMarketDemand = MarketDemand::findAll(['characterID' => $characterID]);

        return $this->render('list', ['mCharacter' => $mCharacter, 'aMarketDemand' => $aMarketDemand]);
    }

    /**
     * @param int $characterID
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCreate($characterID)
    {
        $mCharacter = $this->loadCharacter($characterID);
        $mMarketDemand = new MarketDemand();
        $mMarketDemand->characterID = $characterID;

        if ($this->isAjaxRequest()) {
            $sType = $this->getGetData('sType');

            if ($sType == 'station') {
                $sql = '(SELECT sStation.stationID, sStation.stationName, sStation.stationTypeID FROM staStations as sStation WHERE sStation.stationName LIKE "%' . $_GET['q'] . '%")
                            UNION (SELECT cStation.stationID, cStation.stationName, cStation.stationTypeID FROM api_eve_conquerableStation as cStation WHERE cStation.stationName LIKE "%' . $_GET['q'] . '%")';
            }

            if ($sType == 'item') {
                $sql = 'SELECT typeID, typeName FROM invTypes WHERE typeName LIKE "%' . $_GET['q'] . '%" AND published ="1" ORDER BY typeName';
            }

            $aReturn = \Yii::$app->getDb()->createCommand($sql)->queryAll();

            echo Json::encode($aReturn);
            \Yii::$app->end();
        } elseif ($this->isPostRequest()) {
            if ($mMarketDemand->load($this->getPostData())) {
                if ($mMarketDemand->validate()) {
                    $mMarketDemand->save();

                    return $this->redirect(['/character/market-demands/list', 'characterID' => $mCharacter->characterID]);
                }
            }
        }

        return $this->render('create', ['mCharacter' => $mCharacter, 'mMarketDemand' => $mMarketDemand]);
    }

    public function actionDelete($characterID, $id)
    {
        $mCharacter = $this->loadCharacter($characterID);
        $mMarketDemand = $this->loadMarketDemand($id, false);

        if ($mMarketDemand) {
            $mMarketDemand->delete();
        }

        return $this->redirect(['/character/market-demands/list', 'characterID' => $characterID]);
    }
}

