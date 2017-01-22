<?php

namespace app\components\eve\extend;

use app\components\eve\Item;
use app\models\dump\InvTypeMaterials;
use yii\base\NotSupportedException;

/**
 * Class AbstractProcessableItem
 *
 * @package app\components\eve\extend
 */
abstract class AbstractProcessableItem extends AbstractPriceItem
{
    /** @var array|Item[] $reprocess */
    public $reprocess = [];
    /** @var array|Item[] $refine */
    public $refine = [];
    /** @var int|float $percentReprocess */
    public $percentReprocess;
    /** @var int|float $percentRefine */
    public $percentRefine;

    /**
     * @return $this
     */
    public function calculateReprocess()
    {
        /** @var InvTypeMaterials[] $invTypeMaterials */
        $invTypeMaterials = InvTypeMaterials::find()
            ->joinWith('invType')
            ->where(['invTypes.typeID' => $this->typeID])
            ->all();

        foreach ($invTypeMaterials as $invTypeMaterial) {
            $this->reprocess[] = new Item([
                'typeID' => $invTypeMaterial->materialInvType->typeID,
                'typeName' => $invTypeMaterial->materialInvType->typeName,
                'quantity' => $invTypeMaterial->quantity,
                'groupID' => $invTypeMaterial->materialInvType->groupID
            ]);
        }

        return $this;
    }

    /**
     * @throws NotSupportedException
     */
    public function calculateRefine()
    {
        throw new NotSupportedException('Is not implemented yet.');
    }
}