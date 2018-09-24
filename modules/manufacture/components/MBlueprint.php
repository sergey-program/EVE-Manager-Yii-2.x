<?php

namespace app\modules\manufacture\components;

use app\models\dump\InvTypes;

/**
 * Class MBlueprint
 *
 * @package app\modules\manufacture\components
 */
class MBlueprint
{
    /** @var InvTypes $invType */
    private $invType;
    /** @var int $quantity */
    private $quantity;
    /** @var int $me */
    private $me = 0;
    /** @var int $te */
    private $te = 0;
    /** @var array|MItem[] $mItems */
    private $mItems = [];

    /**
     * MBlueprint constructor.
     *
     * @param InvTypes $invType
     * @param int      $quantity
     */
    public function __construct(InvTypes $invType, $quantity = 1)
    {
        $this->invType = $invType;
        $this->quantity = $quantity;

        $this->loadComponents();
    }

    /**
     * @return $this
     */
    private function loadComponents()
    {
        $iam = $this->invType->getIndustryActivityMaterials()->andWhere(['activityID' => '1'])->all();

        if (!empty($iam)) {
            foreach ($iam as $invTypeMaterial) {
                $this->mItems[] = MManager::createItem($invTypeMaterial->materialTypeID, $invTypeMaterial->quantity);
            }
        }

        return $this;
    }

    /**
     * @param int $me
     *
     * @return $this
     */
    public function setME($me)
    {
        $this->me = $me;

        return $this;
    }

    /**
     * @return int
     */
    public function getME()
    {
        return $this->me;
    }

    /**
     * @param $te
     *
     * @return $this
     */
    public function setTE($te)
    {
        $this->te = $te;

        return $this;
    }

    /**
     * @return int
     */
    public function getTE()
    {
        return $this->te;
    }

    /**
     * @return array|MItem[]
     */
    public function getItems()
    {
        return $this->mItems;
    }

    /**
     * @param int $typeID
     *
     * @return bool
     */
    public function isTypeID($typeID)
    {
        return ($this->invType->typeID == $typeID);
    }

    /**
     * @return InvTypes
     */
    public function getInvType()
    {
        return $this->invType;
    }
}