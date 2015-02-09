<?php

namespace app\models;

use app\models\_extend\AbstractActiveRecord;
use app\models\api\account\ApiKeyInfo;
use app\models\api\account\Character;

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

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if ($this->info) {
            $this->info->delete();
        }

        if ($this->characters) {
            foreach ($this->characters as $mCharacter) {
                $mCharacter->delete();
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
}