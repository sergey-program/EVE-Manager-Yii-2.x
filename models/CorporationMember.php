<?php

namespace app\models;

use app\models\extend\AbstractActiveRecord;

/**
 * Class CorporationMember
 *
 * @package app\models
 *
 * @property int    $characterID
 * @property string $characterName
 * @property int    $startDateTime
 * @property int    $baseID
 * @property string $baseName
 * @property string $title
 * @property int    $logonDateTime
 * @property int    $logoffDateTime
 * @property int    $locationID
 * @property string $locationName
 * @property int    $shipTypeID
 * @property string $shipTypeName
 * @property string $roles
 * @property string $grantableRoles
 */
class CorporationMember extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%corporation_member}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['characterID', 'characterName', 'baseID', 'baseName'], 'safe'],
            [['startDateTime', 'title', 'roles', 'grantableRoles'], 'safe'],
            [['logonDateTime', 'logoffDateTime', 'locationID', 'locationName'], 'safe'],
            [['shipTypeID', 'shipTypeName'], 'safe']
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