<?php

namespace app\controllers;

use app\components\UserIdentity;
use app\controllers\extend\AbstractController;
use app\models\extend\AbstractAccessToken;
use app\models\UserToken;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;

/**
 * Class AuthController
 *
 * @package app\controllers
 */
class AuthController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['sign-in', 'sign-in-callback'], 'roles' => ['?']],
                    ['allow' => true, 'actions' => ['sign-out'], 'roles' => ['@']]
                ]
            ]
        ];
    }

    /**
     * Create link for auth by EVE SSO.
     *
     * @return string
     */
    public function actionSignIn()
    {
        $this->layout = false;

        return $this->render('sign-in');
    }

    /**
     * @return \yii\web\Response
     */
    public function actionSignOut()
    {
        \Yii::$app->user->logout(false);

        return $this->goHome();
    }

    /**
     * Callback function to create new user with code retrieved from EVE SSO.
     *
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionSignInCallback()
    {
        $code = \Yii::$app->session->getFlash('code');

        $dataToken = AbstractAccessToken::getAccessTokenByCode($code);
        $dataCharacter = $this->getCharacterData($dataToken['access_token']);

        // create user
        $userIdentity = UserIdentity::findOne(['characterID' => $dataCharacter['CharacterID']]);

        if (!$userIdentity) {
            $userIdentity = new UserIdentity();
            $userIdentity->characterID = $dataCharacter['CharacterID'];
            $userIdentity->characterName = $dataCharacter['CharacterName'];

            if (!$userIdentity->save()) {
                throw new \ErrorException('Cannot create new user.');
            }
        }

        // update/create token
        $userToken = UserToken::findOne(['userID' => $userIdentity->id]);

        if (!$userToken) {
            $userToken = new UserToken();
            $userToken->userID = $userIdentity->id;
            $userToken->save();
        }

        $userToken->updateAccessTokenBy($dataToken);

        if (\Yii::$app->user->login($userIdentity, 3600 * 24 * 30)) {
            return $this->goHome();
        }

        throw new BadRequestHttpException('Cannot login.');
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
}