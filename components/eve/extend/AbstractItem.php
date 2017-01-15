<?php

namespace app\components\eve\extend;

use app\components\eveCrest\MarketOrders;
use app\models\dump\InvTypes;
use yii\base\NotSupportedException;
use yii\base\Object;

/**
 * Class AbstractItem
 *
 * @package app\components\eve\extend
 */
abstract class AbstractItem extends Object
{
    /** @var int $typeID */
    public $typeID;
    /** @var string $typeName */
    public $typeName;
    /** @var int $groupID */
    public $groupID;
    /** @var int $quantity */
    public $quantity = 1;
    /** @var float|int $priceSell */
    public $priceSell;
    /** @var float|int $priceBuy */
    public $priceBuy;

    /**
     * @throws NotSupportedException
     * @return void
     */
    public function init()
    {
        if (!$this->typeID || !$this->typeName || !$this->groupID) {
            $filter = null;

            if ($this->typeID) {
                $filter = ['typeID' => $this->typeID];
            }

            if ($this->typeName) {
                $filter = ['typeName' => $this->typeName];
            }

            if (!$filter) {
                throw new NotSupportedException('Cannot create query for item detection.');
            }

            /** @var InvTypes $invType */
            $invType = InvTypes::findOne($filter);
            $this
                ->setTypeID($invType->typeID)
                ->setTypeName($invType->typeName)
                ->setGroupID($invType->groupID);
        }

        parent::init();
    }

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
        return $this->typeID;
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
     * @param float $priceSell
     *
     * @return $this
     */
    public function setPriceSell($priceSell)
    {
        $this->priceSell = $priceSell;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriceSell()
    {
        if (is_null($this->priceSell)) {
            $this->setPriceSell(MarketOrders::getPrice($this->typeID, MarketOrders::ORDER_TYPE_SELL));
        }

        return $this->priceSell;
    }

    /**
     * @param float $priceBuy
     *
     * @return $this
     */
    public function setPriceBuy($priceBuy)
    {
        $this->priceBuy = $priceBuy;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriceBuy()
    {
        if (is_null($this->priceBuy)) {
            $this->setPriceBuy(MarketOrders::getPrice($this->typeID, MarketOrders::ORDER_TYPE_BUY));
        }

        return $this->priceBuy;
    }
}