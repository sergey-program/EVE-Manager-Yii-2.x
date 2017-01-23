<?php

namespace app\components\eve;

use app\models\dump\InvTypes;
use yii\helpers\ArrayHelper;

/**
 * Class ItemFactory
 *
 * @package app\components\eve
 */
class ItemFactory
{
    /**
     * Add new item by typeName or typeID. Look in $this->addTypeName() method.
     *
     * @var array $itemArray
     */
    private $itemArray = [];

    /**
     * Created Item from $this->itemArray.
     *
     * @var array $items
     */
    private $items = [];

    /**
     * @param     $typeName
     * @param int $quantity
     *
     * @return $this
     */
    public function addTypeName($typeName, $quantity = 1)
    {
        $this->itemArray[] = ['typeName' => $typeName, 'quantity' => $quantity];

        return $this;
    }

    /**
     * @param int $typeID
     * @param int $quantity
     *
     * @return $this
     */
    public function addTypeID($typeID, $quantity = 1)
    {
        $this->itemArray[] = ['typeID' => $typeID, 'quantity' => $quantity];

        return $this;
    }

    /**
     * @todo check duplicates, maybe add grouping + quantity
     * @return $this
     */
    public function createItems()
    {
        $query = InvTypes::find();
        $tn = ArrayHelper::getColumn($this->itemArray, 'typeName');

        if ($tn) {
            $query->orFilterWhere(['typeNames' => $tn]);
        }

        $ti = ArrayHelper::getColumn($this->itemArray, 'typeID');

        if ($ti) {
            $query->orFilterWhere(['typeID' => $ti]);
        }

        /** @var InvTypes[] $invTypes */
        $invTypes = $query->all();

        foreach ($invTypes as $invType) {
            $quantity = 1;

            foreach ($this->itemArray as $itemArray) {
                if ($itemArray['typeName'] == $invType->typeName || $itemArray['typeID'] == $invType->typeID) {
                    $quantity = $itemArray['quantity'];
                    break;
                }
            }

            $this->items[] = new Item([
                'typeName' => $invType->typeName,
                'typeID' => $invType->typeID,
                'quantity' => $quantity,
                'groupID' => $invType->groupID
            ]);
        }

        return $this;
    }

    /**
     * @return Item[]
     */
    public function getItems()
    {
        return $this->items;
    }
}