<?php

namespace app\models;

use app\models\_extend\AbstractActiveRecord;

/**
 * Class Api
 *
 * @package app\models
 *
 * @var $id
 * @var $userID
 * @var $keyID
 * @var $vCode
 */
class Api extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'api';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['keyID', 'vCode'], 'required'],
            ['userID', 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'keyID' => 'Key ID',
            'vCode' => 'Verification Code'
        ];
    }

    ### relations

    /*
     *         return array(
            'aCharacter' => array(self::HAS_MANY, 'ApiAccountCharacters', 'apiID'),
            'oApiKeyInfo' => array(self::HAS_ONE, 'ApiAccountApiKeyInfo', 'apiID')
        );
     */

    ### functions
}