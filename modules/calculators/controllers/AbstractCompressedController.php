<?php

namespace app\modules\calculators\controllers;

use app\models\dump\InvGroups;

/**
 * Class AbstractCompressedController
 *
 * @package app\modules\calculators\controllers
 */
abstract class AbstractCompressedController extends AbstractCalculatorsController
{
    /**
     * @param array|int[] $array // array of groupID
     *
     * @return InvGroups[]|array|\yii\db\ActiveRecord[]
     */
    protected function getGroups($array)
    {
        return InvGroups::find()->where(['groupID' => $array])->orderBy(['groupName' => 'ASC'])->all();
    }

    /**
     * @param InvGroups[] $groups
     *
     * @return array
     */
    protected function getGroupItems($groups)
    {
        $result = [];
        $groups = $this->getGroups($groups);

        if ($groups) {
            foreach ($groups as $group) {
                $compressed = $group->getCompressed();

                if ($compressed) {
                    foreach ($compressed as $invType) {
                        $result[] = $invType->getItem();
                    }
                }
            }
        }

        return $result;
    }
}