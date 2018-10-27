<?php

namespace app\models;

use app\models\dump\InvTypes;
use app\models\extend\AbstractActiveRecord;

/**
 * Class BlueprintSettings
 *
 * @package app\models
 *
 * @property int      $id
 * @property int      $userID
 * @property int      $typeID
 * @property int      $me
 * @property int      $te
 * @property int      $meHull
 * @property int      $teHull
 * @property int      $meRig
 * @property int      $teRig
 * @property int      $runPrice
 *
 * @property User     $user
 * @property InvTypes $invType
 */
class BlueprintSettings extends AbstractActiveRecord
{
    public static function tableName()
    {
        return '{{%blueprint_settings}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['userID', 'typeID', 'me', 'te', 'meHull', 'teHull'], 'safe'],
            [['meRig', 'teRig', 'runPrice'], 'safe'],
            [['me', 'meRig', 'meHull'], 'default', 'value' => 0],
            [['te', 'teRig', 'teHull'], 'default', 'value' => 0],
            ['runPrice', 'default', 'value' => 0]
        ];
    }

    ### relations

    public function getUser()
    {
    }

    public function getInvType()
    {
    }

    ### functions
}