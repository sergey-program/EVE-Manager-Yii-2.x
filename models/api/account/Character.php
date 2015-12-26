<?php

namespace app\models\api\account;

use app\models\extend\AbstractActiveRecord;
use app\models\Api;

/**
 * Class Character
 *
 * @package app\models\api\account
 *
 * @property int    $id
 * @property int    $apiID
 * @property int    $characterID
 * @property string $characterName
 * @property int    $corporationID
 * @property string $corporationName
 * @property int    $allianceID
 * @property string $allianceName
 * @property int    $factionID
 * @property string $factionName
 * @property int    $timeUpdated
 *
 * @property Api    $api
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
        return [
            'id' => 'ID'
        ];
    }

    ### relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApi()
    {
        return $this->hasOne(Api::className(), ['id' => 'apiID']);
    }

    ### functions

    /**
     * @param int $width
     *
     * @return string
     */
    public function getImageSrc($width = 32)
    {
        return 'https://image.eveonline.com/character/' . $this->characterID . '_' . $width . '.jpg';
    }

    /**
     * @param int $width
     *
     * @return string
     */
    public function getCorporationImageSrc($width = 32)
    {
        return 'https://image.eveonline.com/Corporation/' . $this->corporationID . '_' . $width . '.png';
    }

    /**
     * @param int $width
     *
     * @return string
     */
    public function getAllianceImageSrc($width = 32)
    {
        return 'https://image.eveonline.com/Alliance/' . $this->allianceID . '_' . $width . '.png';
    }
}