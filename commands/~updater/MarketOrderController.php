<?php

namespace app\commands\updater;

use app\models\Api;
use app\modules\character\modules\market\updaters\UpdaterCharacterMarketOrder;
use yii\console\Controller;

class MarketOrderController extends Controller
{
    /**
     *
     */
    public function actionUpdate()
    {
        $aApi = Api::find()->all();

        foreach ($aApi as $mApi) {
            if ($mApi->characters) {
                foreach ($mApi->characters as $mCharacter) {
                    UpdaterCharacterMarketOrder::update($mApi->keyID, $mApi->vCode, $mCharacter->characterID);
                }
            }
        }
    }
}