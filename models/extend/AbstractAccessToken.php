<?php

namespace app\models\extend;

/**
 * Class AbstractAccessToken
 *
 * @package app\models\extend
 *
 * @property int    $userID
 * @property string $accessToken
 * @property string $tokenType
 * @property int    $expiresIn
 * @property string $refreshToken
 * @property int    $timeUpdate
 */
abstract class AbstractAccessToken extends AbstractActiveRecord
{
    /**
     * Check if current access token was expired.
     *
     * @return bool
     */
    public function accessTokenIsExpired()
    {
        // -30 second to be sure
        return ($this->timeUpdate + $this->expiresIn - 30) > time();
    }

    /**
     * Apply already received token to current model.
     *
     * @param array $data
     *
     * @return $this
     * @throws \ErrorException
     */
    public function updateAccessTokenBy($data)
    {
        $this->accessToken = $data['access_token'];
        $this->tokenType = $data['token_type'];
        $this->expiresIn = $data['expires_in'];
        $this->refreshToken = $data['refresh_token'];

        if (!$this->save()) {
            throw new \ErrorException('Cannot update token model for user. userID: ' . $this->userID);
        }

        return $this;
    }

    /**
     * Do call to get new access token by refresh token and update model.
     *
     * @param bool $force
     *
     * @return $this
     */
    public function refreshAccessToken($force = false)
    {
        if ($this->accessTokenIsExpired() || $force) { // call only if token expired
            $clientID = \Yii::$app->params['application']['clientID'];
            $secret = \Yii::$app->params['application']['secret'];
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://login.eveonline.com/oauth/token',
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => 'grant_type=refresh_token&refresh_token=' . $this->refreshToken,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Basic ' . base64_encode($clientID . ':' . $secret),
                    'Content-Type: application/x-www-form-urlencoded',
                    'Host: login.eveonline.com'
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FRESH_CONNECT => true
            ]);

            // ['access_token', 'token_type', 'expires_in', 'refresh_token']
            $result = json_decode(curl_exec($curl), true);

            $this->updateAccessTokenBy($result);
        }

        return $this;
    }

    /**
     * Receive accessToken after SSO auth by code.
     * Use code that was received after sso authentication\redirection.
     *
     * @param string $code
     *
     * @return mixed
     */
    public static function getAccessTokenByCode($code)
    {
        $clientID = \Yii::$app->params['application']['clientID'];
        $secret = \Yii::$app->params['application']['secret'];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://login.eveonline.com/oauth/token',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => 'grant_type=authorization_code&code=' . $code,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode($clientID . ':' . $secret),
                'Content-Type: application/x-www-form-urlencoded',
                'Host: login.eveonline.com'
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FRESH_CONNECT => true
        ]);

        return json_decode(curl_exec($curl), true); // ['access_token', 'token_type', 'expires_in', 'refresh_token']
    }
}
