<?php

namespace app\modules\corporation\controllers;

use app\models\Corporation;
use app\models\CorporationToken;
use app\models\extend\AbstractAccessToken;
use app\modules\corporation\controllers\extend\AbstractCorporationController;
use yii\base\ErrorException;
use yii\web\ForbiddenHttpException;

/**
 * Class InstallController
 *
 * @package app\modules\corporation\controllers
 */
class InstallController extends AbstractCorporationController
{
    /**
     * @return void|string
     */
    public function actionIndex()
    {
        $this
            ->getView()
            ->setPageTitle('Install corporation')
            ->setPageDescription('Assign this site with certain corporation.')
            ->addBread('Corporation')
            ->addBread('Install');

        Corporation::checkCanInstall();

        return $this->render('index');
    }

    /**
     * @throws ErrorException
     */
    public function actionIndexCallback()
    {
        Corporation::checkCanInstall();

        $code = \Yii::$app->session->getFlash('code');

        if (!$code) {
            return $this->redirect(['index']);
        }

        $dataToken = AbstractAccessToken::getAccessTokenByCode($code);
        $dataChar = $this->getCharData($dataToken['access_token']);
        $dataCorp = $this->getCorpSheet($dataToken['access_token']);

        if (isset($dataCorp['error'])) {
            throw new ForbiddenHttpException($dataCorp['error']);
        }

        $corporation = Corporation::findOne(['corporationID' => $dataCorp['result']['corporationID']]);

        if (!$corporation) {
            $corporation = new Corporation();
            $corporation->corporationID = $dataCorp['result']['corporationID'];
            $corporation->corporationName = $dataCorp['result']['corporationName'];
            $corporation->characterID = $dataChar['CharacterID'];
            $corporation->characterName = $dataChar['CharacterName'];

            if (!$corporation->save()) {
                throw new ErrorException('Cannot save new corporation.');
            }
        }

        $corporationToken = CorporationToken::findOne(['corporationID' => $corporation->id]);

        if (!$corporationToken) {
            $corporationToken = new CorporationToken();
            $corporationToken->corporationID = $corporation->id;
            $corporationToken->accessToken = $dataToken['access_token'];
            $corporationToken->refreshToken = $dataToken['refresh_token'];
            $corporationToken->expiresIn = $dataToken['expires_in'];
            $corporationToken->tokenType = $dataToken['token_type'];

            if (!$corporationToken->save()) {
                throw new ErrorException('Cannot update token.');
            }
        }

        return $this->render('index-callback', ['corporation' => $corporation]);
    }

    /**
     * @param string $accessToken
     *
     * @return array|mixed
     */
    private function getCharData($accessToken)
    {
        $hCurl = curl_init();

        curl_setopt_array($hCurl, [
            CURLOPT_URL => 'https://login.eveonline.com/oauth/verify',
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $accessToken, 'Content-Type: application/json'],
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FRESH_CONNECT => true
        ]);

        return json_decode(curl_exec($hCurl), true);
    }

    /**
     * @param string $accessToken
     *
     * @return array|mixed
     */
    private function getCorpSheet($accessToken)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.eveonline.com/corp/CorporationSheet.xml.aspx?accessToken=' . $accessToken . '&accessType=corporation',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FRESH_CONNECT => true
        ]);

        $resultString = curl_exec($curl);
        $xml = simplexml_load_string($resultString);

        return json_decode(json_encode($xml), true);
    }
}