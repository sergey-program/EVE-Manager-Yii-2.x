<?php

namespace app\models;

use app\models\extend\AbstractAccessToken;

/**
 * Class CorporationToken
 *
 * @package app\models
 *
 * @property int    $id
 * @property int    $corporationID
 * @property string $accessToken
 * @property string $tokenType
 * @property string $refreshToken
 * @property int    $expiresIn
 * @property int    $timeUpdate
 */
class CorporationToken extends AbstractAccessToken
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%corporation_token}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['timeUpdate', 'default', 'value' => time()],
            ['corporationID', 'required'],
            [['accessToken', 'tokenType', 'refreshToken', 'expiresIn', 'timeUpdate'], 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID'
        ];
    }

    ### relations

    ### functions
}