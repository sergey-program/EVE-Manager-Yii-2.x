<?php

namespace app\models\api\account;

use app\models\_extend\AbstractActiveRecord;

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
        return 'api_account_character';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }
}