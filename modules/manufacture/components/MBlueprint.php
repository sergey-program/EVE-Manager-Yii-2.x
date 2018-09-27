<?php

namespace app\modules\manufacture\components;

use app\models\dump\IndustryActivityMaterials;
use app\models\dump\InvTypes;

/**
 * Class MBlueprint
 *
 * @package app\modules\manufacture\components
 */
class MBlueprint extends AbstractItem
{
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
        $this->mItems = [];
        /** @var IndustryActivityMaterials[] $iam */
        $iam = $this->getInvType()->getIndustryActivityMaterials()->andWhere(['activityID' => '1'])->cache(60 * 60 * 24)->all();

        if (!empty($iam)) {
            foreach ($iam as $invTypeMaterial) {
                $quantity = ($this->getME() > 0)
                    ? ceil($invTypeMaterial->quantity - ($invTypeMaterial->quantity * ($this->getME() / 100)))
                    : $invTypeMaterial->quantity;

                $this->mItems[$invTypeMaterial->materialTypeID] = MManager::createItem($invTypeMaterial->materialTypeID, $quantity);
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
        $this->loadComponents();

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
}