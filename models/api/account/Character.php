<?php

namespace app\models\api\account;

use app\models\_extend\AbstractActiveRecord;
use app\models\Api;

/**
 * Class Character
 *
 * @package app\models\api\account
 * @var $id
 * @var $apiID
 * @var $characterID
 * @var $characterName
 * @var $corporationID
 * @var $corporationName
 * @var $allianceID
 * @var $allianceName
 * @var $factionID
 * @var $factionName
 */
class Character extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'api_account_characters';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['apiID', 'characterID'], 'required'],
            [['characterName', 'corporationID', 'corporationName', 'allianceID', 'allianceName', 'factionID', 'factionName'], 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    ### relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApi()
    {
        return $this->hasOne(Api::className(), ['id' => 'apiID']);
    }
}