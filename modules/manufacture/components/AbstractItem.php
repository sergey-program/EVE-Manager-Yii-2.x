<?php

namespace app\modules\manufacture\components;

use app\models\dump\InvTypes;

/**
 * Class AbstractItem
 *
 * @package app\modules\manufacture\components
 */
abstract class AbstractItem
{
    /** @var InvTypes|null $invType */
    protected $invType;
    /** @var int $quantity */
    protected $quantity;

    /**
     * @return InvTypes|null
     */
    public function getInvType()
    {
        return $this->invType;
    }

    /**
     * @param InvTypes $invType
     *
     * @return $this
     */
    public function setInvType(InvTypes $invType)
    {
        $this->invType = $invType;

        return $this;
    }

    /**
     * @param int $typeID
     *
     * @return bool
     */
    public function isTypeID($typeID)
    {
        return $this->getInvType() ? ($this->getInvType()->typeID == $typeID) : false;
    }

    /**
     * @param int $typeID
     *
     * @return bool
     */
    public function getIsType($typeID)
    {
        return $this->getInvType() ? ($this->getInvType()->typeID == $typeID) : false;
    }

    /**
     * @param $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @param int $quantity
     *
     * @return $this
     */
    public function addQuantity($quantity)
    {
        $this->quantity += $quantity;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}