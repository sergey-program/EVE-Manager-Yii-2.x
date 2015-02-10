<?php
namespace app\modules\character\modules\market\controllers;

use app\models\MarketDemand;

use app\modules\character\modules\market\controllers\_extend\MarketController;
use app\modules\prices\updaters\UpdaterEveCentral;
use yii\helpers\Json;

class DemandController extends MarketController
{
    /**
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        $this
            ->addBread(['label' => 'Demands', 'url' => ['/character/market/demand/index', 'characterID' => $this->mCharacter->characterID]])
            ->addBread(['label' => 'Index']);

        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $this
            ->addBread(['label' => 'Demands', 'url' => ['/character/market/demand/index', 'characterID' => $this->mCharacter->characterID]])
            ->addBread(['label' => 'List']);

        $aMarketDemand = MarketDemand::findAll(['characterID' => $this->mCharacter->characterID]);

        return $this->render('list', ['aMarketDemand' => $aMarketDemand]);
    }

    /**
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCreate()
    {
        $this
            ->addBread(['label' => 'Demands', 'url' => ['/character/market/demand/index', 'characterID' => $this->mCharacter->characterID]])
            ->addBread(['label' => 'Create']);

        $mMarketDemand = new MarketDemand();
        $mMarketDemand->characterID = $this->mCharacter->characterID;

        if ($this->isAjaxRequest()) {
            $sType = $this->getGetData('sType');

            if ($sType == 'station') {
                $sSql = '(SELECT sStation.stationID, sStation.stationName, sStation.stationTypeID FROM staStations as sStation WHERE sStation.stationName LIKE "%' . $_GET['q'] . '%")
                        UNION
                        (SELECT cStation.stationID, cStation.stationName, cStation.stationTypeID FROM api_eve_conquerableStation as cStation WHERE cStation.stationName LIKE "%' . $_GET['q'] . '%")';
            } elseif ($sType == 'item') {
                $sSql = 'SELECT typeID, typeName FROM invTypes WHERE typeName LIKE "%' . $_GET['q'] . '%" AND published ="1" ORDER BY typeName';
            }

            $aReturn = \Yii::$app->getDb()->createCommand($sSql)->queryAll();

            echo Json::encode($aReturn); // @todo change response type
            \Yii::$app->end();
        } elseif ($this->isPostRequest()) {
            if ($mMarketDemand->load($this->getPostData())) {
                if ($mMarketDemand->validate()) {
                    $mMarketDemand->save();
                    UpdaterEveCentral::addType($mMarketDemand->typeID);

                    return $this->redirect(['/character/market/demand/list', 'characterID' => $this->mCharacter->characterID]);
                }
            }
        }

        return $this->render('create', ['mMarketDemand' => $mMarketDemand]);
    }

    /**
     * @param int $id
     *
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $mMarketDemand = $this->loadMarketDemand($id, false);

        if ($mMarketDemand) {
            $mMarketDemand->delete();
        }

        return $this->redirect(['/character/market-demands/list', 'characterID' => $this->mCharacter->characterID]);
    }
}

