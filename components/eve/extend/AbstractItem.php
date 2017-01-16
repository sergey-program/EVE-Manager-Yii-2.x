<?php

namespace app\components\eve\extend;

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

    /**
     * @throws NotSupportedException
     * @return void
     */
    public function init()
    {
        // load base data
        if (!$this->typeID || !$this->typeName || !$this->groupID) {
            $filter = null;

            if ($this->typeID) {
                $filter = ['typeID' => $this->typeID];
            } elseif ($this->typeName) {
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
     * @param int $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }
}