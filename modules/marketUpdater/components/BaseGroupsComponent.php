<?php

namespace app\modules\marketUpdater\components;

use app\models\dump\InvGroups;
use app\models\MarketUpdateGroup;
use yii\base\Component;
use yii\helpers\ArrayHelper;

/**
 * Class BaseGroupsComponent
 *
 * @property array $groupIDs
 * @property array $invGroups
 *
 * @package app\modules\marketUpdater\components
 */
class BaseGroupsComponent extends Component
{
    /** @var int $cacheTime */
    public $cacheTime = 60 * 60 * 24;
    public $orderBy = ['groupID' => SORT_ASC];

    /**
     * @return array
     */
    public function getGroupIDs()
    {
        return ArrayHelper::getColumn(MarketUpdateGroup::find()->addOrderBy($this->orderBy)->all(), 'groupID');
    }

    /**
     * @return InvGroups[]|array
     */
    public function getInvGroups()
    {
        return InvGroups::find()->where(['groupID' => $this->getGroupIDs()])->addOrderBy($this->orderBy)->all();
    }
}