<?php

namespace app\components\selectors;

use app\models\dump\InvTypes;
use yii\base\Component;
use yii\db\Query;

/**
 * Class OresComponent
 *
 * @package app\components\selectors
 *
 * @property Query      $query
 *
 * @property InvTypes[] $compressed
 * @property InvTypes[] $notCompressed
 * @property InvTypes[] $all
 */
class OresComponent extends Component
{
    /** @var array $oreIDs */
    public $oreIDs = [450, 451, 452, 453, 454, 455, 456, 457, 458, 459, 460, 461, 462, 467, 468, 469];

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuery()
    {
        return InvTypes::find()->where(['published' => true, 'groupID' => $this->oreIDs]);
    }

    /**
     * @param int $filterID
     *
     * @return InvTypes[]|array|\yii\db\ActiveRecord[]
     */
    public function getCompressed($filterID = null)
    {
        $invTypes = $this->query->andWhere(['like', 'typeName', 'compressed'])->all();

        return $this->filterByMineral($invTypes, $filterID);
    }

    /**
     * @param int $filterID
     *
     * @return InvTypes[]|array|\yii\db\ActiveRecord[]
     */
    public function getNotCompressed($filterID = null)
    {
        $invTypes = $this->query->andWhere(['not like', 'typeName', 'compressed'])->all();

        return $this->filterByMineral($invTypes, $filterID);
    }

    /**
     * @param int $filterID
     *
     * @return InvTypes[]|array|\yii\db\ActiveRecord[]
     */
    public function getAll($filterID = null)
    {
        $invTypes = $this->query->all();

        return $this->filterByMineral($invTypes, $filterID);
    }

    /**
     * @param InvTypes[]|array $invTypes
     * @param int              $typeID
     *
     * @return array
     */
    public function filterByMineral(array $invTypes, $typeID)
    {
        $result = [];

        if (!empty($invTypes)) {
            // @todo optimize relations or query
            foreach ($invTypes as $invType) {
                if ($invType->invTypeMaterials) {
                    foreach ($invType->invTypeMaterials as $invTypeMaterial) {
                        if ($invTypeMaterial->materialTypeID == $typeID) {
                            $result[] = $invType;
                        }
                    }
                }
            }
        }

        return $result;
    }
}