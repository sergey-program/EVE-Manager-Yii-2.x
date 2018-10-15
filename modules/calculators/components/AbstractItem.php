<?php

namespace app\modules\calculators\components;

use app\models\dump\InvTypes;
use yii\base\BaseObject;

/**
 * Class AbstractItem
 *
 * @package app\modules\calculators\components
 *
 * @property InvTypes|null $invType
 * @property int|null      $typeID
 */
abstract class AbstractItem extends BaseObject implements ItemInterface
{
    /** @var InvTypes|null $invType */
    private $invType;
    /** @var int $quantity */
    private $quantity = 1;

    /**
     * @param InvTypes $invType
     *
     * @return $this|ItemInterface
     */
    public function setInvType(InvTypes $invType)
    {
        $this->invType = $invType;

        return $this;
    }

    /**
     * @return InvTypes|null
     */
    public function getInvType()
    {
        return $this->invType;
    }

    /**
     * @return int|null
     */
    public function getTypeID()
    {
        return $this->invType ? $this->invType->typeID : null;
    }

    /**
     * @param int $typeID
     *
     * @return bool
     */
    public function isTypeID($typeID)
    {
        return $this->invType ? ($this->invType->typeID == $typeID) : false;
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