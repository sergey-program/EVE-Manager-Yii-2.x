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
            ['keyID', 'integer'],
            ['userID', 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'userID' => 'User',
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

    public function hasInfo()
    {
        return false;
    }

    public function hasCharacters()
    {
        return false;
    }
}