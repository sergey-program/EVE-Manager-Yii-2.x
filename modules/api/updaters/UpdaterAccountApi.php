<?php

namespace app\modules\api\updaters;

use app\calls\account\CallApiKeyInfo;
use app\calls\account\CallCharacters;
use app\models\Api;
use yii\web\NotFoundHttpException;

class UpdaterAccountApi
{
    const BY_API_ID = 'id';
    const BY_KEY_ID = 'keyID';

    /**
     * Update using keyID or api id.
     *
     * @param int    $iApiID
     * @param string $sBy
     *
     * @throws NotFoundHttpException
     */
    public static function updateBy($iApiID, $sBy = self::BY_API_ID)
    {
        $mApi = Api::findOne([$sBy => $iApiID]);

        if (!$mApi) {
            throw new NotFoundHttpException('Such api does not exist.');
        }

        self::update($mApi);
    }

    /**
     * Update using Api model.
     *
     * @param Api $mApi
     */
    public static function update(Api $mApi)
    {
        $oCallApiKeyInfo = new CallApiKeyInfo();
        $oCallApiKeyInfo->apiID = $mApi->id;
        $oCallApiKeyInfo->keyID = $mApi->keyID;
        $oCallApiKeyInfo->vCode = $mApi->vCode;
        $oCallApiKeyInfo->update();

        $oCallCharacters = new CallCharacters();
        $oCallCharacters->apiID = $mApi->id;
        $oCallCharacters->keyID = $mApi->keyID;
        $oCallCharacters->vCode = $mApi->vCode;
        $oCallCharacters->update();
    }
}