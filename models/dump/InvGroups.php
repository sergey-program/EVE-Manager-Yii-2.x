<?php

namespace app\models\dump;

use app\models\extend\AbstractActiveRecord;

/**
 * Class InvGroups
 *
 * @package app\models\dump
 *
 * @property int        $groupID
 * @property int        $categoryID
 * @property int        $groupName
 * @property int        $iconID
 * @property bool|int   $useBasePrice
 * @property bool|int   $anchored
 * @property bool|int   $anchorable
 * @property bool|int   $fittableNonSingleton
 * @property bool|int   $published
 *
 * @property InvTypes[] $invTypes
 */
class InvGroups extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'invGroups';
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

    ### relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvTypes()
    {
        return $this->hasMany(InvTypes::class, ['groupID' => 'groupID'])->andWhere(['published' => true]);
    }

    ### functions
}