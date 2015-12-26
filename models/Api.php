<?php

namespace app\models;

use app\models\extend\AbstractApi;
use app\models\api\account\ApiKeyInfo;
use app\models\api\account\Character;

/**
 * Class Api
 *
 * @package app\models
 *
 * @property int         $id
 * @property int         $userID
 * @property int         $keyID
 * @property string      $vCode
 * @property int         $timeCreated
 *
 * @property ApiKeyInfo  $info
 * @property Character[] $characters
 */
class Api extends AbstractApi
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
            [['keyID', 'vCode', 'userID'], 'required'],
            ['keyID', 'integer'],
            ['timeCreated', 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'userID' => 'User ID',
            'keyID' => 'Key ID',
            'vCode' => 'Verification Code'
        ];
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if ($this->info) {
            $this->info->delete();
        }

        if ($this->characters) {
            foreach ($this->characters as $character) {
                $character->delete();
            }
        }

        return parent::beforeDelete();
    }

    ### relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfo()
    {
        return $this->hasOne(ApiKeyInfo::className(), ['apiID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacters()
    {
        return $this->hasMany(Character::className(), ['apiID' => 'id']);
    }

    ### functions

    /**
     * @return bool
     */
    public function isFullAccess()
    {
        if ($this->info) {
            return ($this->info->accessMask == ApiKeyInfo::ACCESS_MASK_FULL);
        }

        return false;
    }
}