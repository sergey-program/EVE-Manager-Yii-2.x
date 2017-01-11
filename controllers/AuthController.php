<?php

namespace app\controllers;

use app\components\UserIdentity;
use app\controllers\extend\AbstractController;
use app\models\UserToken;

/**
 * Class AuthController
 *
 * @package app\controllers
 */
class AuthController extends AbstractController
{
    /**
     * Create link for auth by EVE SSO.
     *
     * @return string
     */
    public function actionSignIn()
    {
        $scopes = [
            'characterAccountRead', 'characterAssetsRead', 'characterBookmarksRead',
            'characterCalendarRead', 'characterChatChannelsRead', 'characterClonesRead', 'characterContactsRead',
            'characterContactsWrite', 'characterContractsRead', 'characterFactionalWarfareRead',
            'characterFittingsRead', 'characterFittingsWrite', 'characterIndustryJobsRead', 'characterKillsRead',
            'characterLocationRead', 'characterLoyaltyPointsRead', 'characterMailRead', 'characterMarketOrdersRead',
            'characterMedalsRead', 'characterNavigationWrite', 'characterNotificationsRead',
            'characterOpportunitiesRead', 'characterResearchRead', 'characterSkillsRead', 'characterStatsRead',
            'characterWalletRead', 'corporationAssetsRead', 'corporationBookmarksRead', 'corporationContactsRead',
            'corporationContractsRead', 'corporationFactionalWarfareRead', 'corporationIndustryJobsRead',
            'corporationKillsRead', 'corporationMarketOrdersRead', 'corporationMedalsRead',
            'corporationMembersRead', 'corporationShareholdersRead', 'corporationStructuresRead',
            'corporationWalletRead', 'fleetRead', 'fleetWrite', 'publicData', 'remoteClientUI', 'structureVulnUp'];

        $url = 'https://login.eveonline.com/oauth/authorize/';
        $url .= '?client_id=' . \Yii::$app->params['application']['clientID'];
        $url .= '&response_type=code';
        $url .= '&redirect_uri=http://eve-manager/callback-url';
        $url .= '&scope=characterAssetsRead%20characterChatChannelsRead%20characterContactsRead%20characterLocationRead%20characterMailRead%20characterMarketOrdersRead%20characterNotificationsRead%20characterSkillsRead%20characterWalletRead';
//        $url .= '&scope=' . implode("%20",$scopes);
        $url .= '&state=uniquestate123';

        return $this->render('sign-in', ['signInUrl' => $url]);
    }

    /**
     * Callback function to create new user with code retrieved from EVE SSO.
     *
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionSignInCallback()
    {
        $ssoCode = $this->get('code');

        // get token
        $dataToken = $this->getAccessToken($ssoCode);
        // get character
        $dataCharacter = $this->getCharacterData($dataToken['access_token']);

        // create user
        $userIdentity = UserIdentity::findOne(['characterID' => $dataCharacter['CharacterID']]);

        if (!$userIdentity) {
            $userIdentity = new UserIdentity();
            $userIdentity->characterID = $dataCharacter['CharacterID'];
            $userIdentity->characterName = $dataCharacter['CharacterName'];

            if (!$userIdentity->save()) {
                throw new \Exception('Cannot create new user.');
            }
        }

        // create token
        $userToken = new UserToken();
        $userToken->userID = $userIdentity->id;
        $userToken->accessToken = $dataToken['access_token'];
        $userToken->tokenType = $dataToken['token_type'];
        $userToken->expiresIn = $dataToken['expires_in'];
        $userToken->refreshToken = $dataToken['refresh_token'];
        $userToken->save();

        if (\Yii::$app->user->login($userIdentity, 3600 * 24 * 30)) {
            return $this->goHome();
        }

        return $this->render('sign-in-callback', ['code' => $ssoCode]);
    }

    /**
     * @param string $ssoCode
     *
     * @return mixed
     */
    private function getAccessToken($ssoCode)
    {
        $basic = base64_encode(\Yii::$app->params['application']['clientID'] . ':' . \Yii::$app->params['application']['secret']);

        $curl = curl_init('https://login.eveonline.com/oauth/token');

        curl_setopt_array($curl, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => 'grant_type=authorization_code&code=' . $ssoCode,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . $basic,
                'Content-Type: application/x-www-form-urlencoded',
                'Host: login.eveonline.com'
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FRESH_CONNECT => true
        ]);

        $resultString = curl_exec($curl);

        // $resultString['access_token']
        // $resultString['token_type']
        // $resultString['expires_in']
        // $resultString['refresh_token']

        return json_decode($resultString, true);
    }

    /**
     * @param string $accessToken
     *
     * @return array
     */
    private function getCharacterData($accessToken)
    {
        $url = 'https://login.eveonline.com/oauth/verify ';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $accessToken, 'Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);

        $resultString = curl_exec($curl);

//        "CharacterID": 90961888,
//        "CharacterName": 'Char name',
//        "ExpiresOn": '2017-01-11T15:16:38',
//        "Scopes":"characterAssetsRead characterChatChannelsRead ...",
//        "TokenType":"Character",
//        "CharacterOwnerHash":"i2IP2Vp3yZULDG7K6aJWSPmEBXU=",
//        "IntellectualProperty":"EVE"

        return json_decode($resultString, true);
    }

    /**
     * @return string|\yii\web\Response
     */
//    public function actionLogin()
//    {
//        if (!\Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }
//
//        $this->getView()->setTitle('Login');
//
//        $fLogin = new FormLogin();
//
//        if ($fLogin->load($this->getPost()) && $fLogin->login()) {
//            return $this->goBack();
//        }
//
//        return $this->render('login', ['fLogin' => $fLogin]);
//    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout(false);

        return $this->goHome();
    }

}