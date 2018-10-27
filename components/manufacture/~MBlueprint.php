<?php

namespace app\modules\manufacture\components;

use app\models\dump\IndustryActivityMaterials;
use app\models\dump\InvTypes;

/**
 * Class MBlueprint
 *
 * @package app\modules\manufacture\components
 */
class MBlueprint extends AbstractBlueprint
{
    /**
     * MBlueprint constructor.
     *
     * @param InvTypes $invType // bpo
     * @param int      $runs
     */
    public function __construct(InvTypes $invType, $runs = 1)
    {
        $this->setInvType($invType);
        $this->setRuns($runs);
        $this->loadMaterials();         // load base (qty=1) materials
        $this->recalculateMaterials();  // recalculate qty regarding runs
    }

    /**
     * @return $this
     */
    protected function loadMaterials()
    {
        $this->mItems = [];
        /** @var IndustryActivityMaterials[] $iam */
        $iam = $this->getInvType()->industryActivityMaterialsManufacture;

        if (!empty($iam)) {
            foreach ($iam as $invTypeMaterial) {
                $mItem = MManager::createItemMaterial($invTypeMaterial->materialTypeID);
                $mItem->setBaseQuantity($invTypeMaterial->quantity);

                $this->mItems[$invTypeMaterial->materialTypeID] = $mItem;
            }
        }

        return $this;
    }

    /**
     *
     */
    protected function recalculateMaterials()
    {
        foreach ($this->getItems() as $mItem) {
            $me = 1 - ($this->getME() / 100);
            $rig = 1 - ($this->getMeRig() / 100);
            $hull = 1 - ($this->getMeHull() / 100); // @todo calculate hull me bonus

            $qty = ceil($mItem->getBaseQuantity() * $me * $rig * $hull);
            $mItem->setQuantity($qty);
        }
    }
}