<?php

namespace app\modules\manufacture\components;

use app\models\dump\InvTypes;

/**
 * Class MItem
 *
 * @package app\modules\manufacture\components
 */
class MItem
{
    /** @var InvTypes| $invType */
    private $invType;
    /** @var int $quantity */
    private $quantity;
    /** @var MBlueprint|null $mBlueprint */
    private $mBlueprint;

    /**
     * MItem constructor.
     *
     * @param InvTypes $invType
     * @param int      $quantity
     */
    public function __construct(InvTypes $invType, $quantity = 1)
    {
        $this->invType = $invType;
        $this->quantity = $quantity;
        $this->mBlueprint = MManager::createBlueprint($this->invType);
    }

    /**
     * @return bool
     */
    public function hasBlueprint()
    {
        return is_null($this->mBlueprint) ? false : true;
    }

    /**
     * @return MBlueprint|null
     */
    public function getBlueprint()
    {
        return $this->mBlueprint;
    }

    /**
     * @return InvTypes
     */
    public function getInvType()
    {
        return $this->invType;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}