<?php

namespace app\modules\manufacture\components;

use app\components\items\Item;
use app\models\dump\InvTypes;
use yii\base\Component;

/**
 * Class LastOpenedItemsComponent
 *
 * @package app\modules\manufacture\components
 *
 * @property Item[] $items
 * @property int[]  $typeIDs
 */
class LastOpenedItemsComponent extends Component
{
    const LAST_OPENED_ITEMS_VAR = 'last_opened_manufacture_type_ids';

    /** @var float|int $cacheTime */
    public $cacheTime = 60 * 60 * 24 * 3;
    /** @var int $limit */
    public $limit = 10;

    /**
     * @param int $typeID
     */
    public function addTypeID($typeID)
    {
        $typeIDs = $this->getTypeIDs();     // raw cache array|int[]

        if (!in_array($typeID, $typeIDs)) { // merge new with old
            $typeIDs[] = $typeID;
        }

        if (\Yii::$app->cache) {
            \Yii::$app->cache->set(self::LAST_OPENED_ITEMS_VAR, $typeIDs, $this->cacheTime);
        }
    }

    /**
     * @return array
     */
    public function getItems()
    {
        $result = [];
        $typeIDs = $this->getTypeIDs();

        if (!empty($typeIDs)) {
            $invTypes = InvTypes::findAll(['typeID' => $typeIDs]);

            foreach ($invTypes as $invType) {
                $result[] = $invType->getItem();
            }
        }

        return $result;
    }

    /**
     * @return int[]|array
     */
    public function getTypeIDs()
    {
        if (\Yii::$app->cache) {
            $result = \Yii::$app->cache->get(self::LAST_OPENED_ITEMS_VAR);
        } else {
            $result = false;
        }

        $result = is_array($result) ? $result : [];
        $result = $this->normalize($result);
        return $result;
    }

    /**
     * @param int[]|array $array
     *
     * @return array
     */
    private function normalize($array)
    {
        foreach ($array as $key => $value) { // $value === typeID
            if (!is_numeric($value)) {
                unset($array[$key]);
            }
        }

        return array_slice($array, 0, $this->limit);
    }

    public function hasItems()
    {
        return !empty($this->getItems());
    }
}