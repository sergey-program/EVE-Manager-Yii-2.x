<?php

namespace app\models\dump;

use app\models\extend\AbstractActiveRecord;
use app\models\MarketUpdateGroup;

/**
 * Class InvGroups
 *
 * @package app\models\dump
 *
 * @property int               $groupID
 * @property int               $categoryID
 * @property int               $groupName
 * @property int               $iconID
 * @property bool|int          $useBasePrice
 * @property bool|int          $anchored
 * @property bool|int          $anchorable
 * @property bool|int          $fittableNonSingleton
 * @property bool|int          $published
 *
 * @property InvTypes[]        $invTypes
 * @property MarketUpdateGroup $marketUpdateGroup
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
        return $this->hasMany(InvTypes::class, ['groupID' => 'groupID'])->andWhere(['published' => true])->cache(60 * 60 * 24);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarketUpdateGroup()
    {
        return $this->hasOne(MarketUpdateGroup::class, ['groupID' => 'groupID'])->cache(60 * 1.5);
    }

    ### functions

    /**
     * @return InvTypes[]|array|\yii\db\ActiveRecord[]
     */
    public function getCompressedIce()
    {
        return $this->getInvTypes()->andWhere(['volume' => 100])->andWhere('marketGroupID IS NOT NULL')->all();
    }

    /**
     * @return InvTypes[]|array|\yii\db\ActiveRecord[]
     */
    public function getCompressedOre()
    {
        return $this->getInvTypes()->andWhere(['portionSize' => 1])->andWhere('marketGroupID IS NOT NULL')->all();
    }
}