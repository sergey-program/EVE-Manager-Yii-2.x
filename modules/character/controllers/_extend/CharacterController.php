<?php

namespace app\modules\character\controllers\_extend;

use app\controllers\_extend\AbstractController;
use app\models\api\account\Character;
use yii\web\NotFoundHttpException;

abstract class CharacterController extends AbstractController
{
    public $layout = 'main';
    public  $mCharacter;

    /**
     * Autoload character by characterID in url.
     */
    public function init()
    {
        parent::init();
        $iCharacterID = $this->getGetData('characterID');

        if ($iCharacterID) {
            $this->mCharacter = Character::findOne(['characterID' => $iCharacterID]);
        }
    }

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
}