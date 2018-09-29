<?php

namespace app\components\eve;

use app\models\dump\InvTypes;
use yii\base\BaseObject;

/**
 * Class Item
 *
 * @package app\components\eve
 */
class Item extends BaseObject
{
    /** @var int $typeID */
    public $typeID;
    /** @var string $typeName */
    public $typeName;
    /** @var float|int $volume */
    public $volume;
    /** @var int $groupID */
    public $groupID;
    /** @var int $quantity */
    public $quantity = 1;
    /** @var float|int $priceSell */
    public $priceSell = 0;
    /** @var float|int $priceBuy */
    public $priceBuy = 0;

    /**
     * @param int $typeID
     *
     * @return $this
     */
    public function setTypeID($typeID)
    {
        $this->typeID = $typeID;

        return $this;
    }

    /**
     * @return int
     */
    public function getTypeID()
    {
        return $this->typeID;
    }

    /**
     * @param string $typeName
     *
     * @return $this
     */
    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;

        return $this;
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * @param float|int $volume
     *
     * @return $this
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * @param int $quantity
     *
     * @return float|int
     */
    public function getVolume($quantity = null)
    {
        return $this->volume * (is_numeric($quantity) ? $quantity : $this->quantity);
    }

    /**
     * @param int $groupID
     *
     * @return $this
     */
    public function setGroupID($groupID)
    {
        $this->groupID = $groupID;

        return $this;
    }

    /**
     * @return int
     */
    public function getGroupID()
    {
        return $this->groupID;
    }

    /**
     * @param int $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float|int $priceSell
     *
     * @return $this
     */
    public function setPriceSell($priceSell)
    {
        $this->priceSell = $priceSell;

        return $this;
    }

    /**
     * @param int $quantity
     *
     * @return int
     */
    public function getPriceSell($quantity = null)
    {
        return $this->priceSell * (is_numeric($quantity) ? $quantity : $this->quantity);
    }

    /**
     * @param float|int $priceBuy
     *
     * @return $this
     */
    public function setPriceBuy($priceBuy)
    {
        $this->priceBuy = $priceBuy;

        return $this;
    }

    /**
     * @param int $quantity
     *
     * @return int
     */
    public function getPriceBuy($quantity = null)
    {
        return $this->priceBuy * (is_numeric($quantity) ? $quantity : $this->quantity);
    }

    /**
     * @return InvTypes|null
     */
    public function getInvTypeModel()
    {
        return InvTypes::findOne($this->typeID);
    }
}