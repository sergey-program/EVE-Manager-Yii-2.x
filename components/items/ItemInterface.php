<?php

namespace app\components\items;

use app\models\dump\InvTypes;

/**
 * Interface ItemInterface
 */
interface ItemInterface
{
    /**
     * @param InvTypes $invType
     *
     * @return $this
     */
    public function setInvType(InvTypes $invType);

    /**
     * @return InvTypes
     */
    public function getInvType();

    /**
     * @var int $typeID
     *
     * @return bool
     */
    public function isTypeID($typeID);

    /**
     * @return int
     */
    public function getTypeID();

    /**
     * @param int $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity);

    /**
     * @param int $quantity
     *
     * @return $this
     */
    public function addQuantity($quantity);

    /**
     * @return int
     */
    public function getQuantity();
}
