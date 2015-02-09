<?php

namespace app\modules\character\controllers\_extend;

use app\controllers\_extend\AbstractController;
use app\models\api\account\Character;
use app\models\MarketDemand;
use yii\web\NotFoundHttpException;

abstract class CharacterController extends AbstractController
{
    public $layout = 'main';

    /**
     * @param int $id
     *
     * @return static
     * @throws NotFoundHttpException
     */
    public function loadCharacter($id)
    {
        $mCharacter = Character::findOne(['characterID' => $id]);

        if (!$mCharacter) {
            throw new NotFoundHttpException('Such character does not exist.');
        }

        return $mCharacter;
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