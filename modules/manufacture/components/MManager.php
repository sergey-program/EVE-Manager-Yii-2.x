<?php

namespace app\modules\manufacture\components;

use app\models\dump\IndustryActivityProducts;
use app\models\dump\InvTypes;

/**
 * Class MManager
 *
 * @package app\modules\manufacture\components
 */
class MManager
{
    /**
     * @param int|InvTypes $invType
     * @param int          $quantity
     *
     * @return MItem
     */
    public static function createItem($invType, $quantity = 1)
    {
        if (is_numeric($invType)) {
            $invType = InvTypes::find()->where(['typeID' => $invType])->cache(60 * 60 * 24)->one();
        }

        return new MItem($invType, $quantity);
    }

    /**
     * @param InvTypes $invType
     *
     * @return MBlueprint|null
     */
    public static function createBlueprint($invType)
    {
        $invTypeID = is_numeric($invType) ? $invType : $invType->typeID;
        $iap = IndustryActivityProducts::find()->where(['and', ['activityID' => '1'], ['productTypeID' => $invTypeID]])->cache(60 * 60 * 24)->one();

        if (!empty($iap)) {
            return new MBlueprint(InvTypes::findOne(['typeID' => $iap->typeID])); // bpo
        }

        return null;
    }

    /**
     * @param MItem $mItem
     * @param int   $quantity
     *
     * @return MTotal
     */
    public static function calculateTotal(MItem $mItem, $quantity = 1)
    {
        return new MTotal($mItem, $quantity);
    }

    /**
     * @param MItem $mItem
     * @param int   $typeID
     * @param int   $me
     */
    public static function setME(MItem $mItem, $typeID, $me)
    {
        if ($mItem->hasBlueprint()) {
            if ($mItem->getBlueprint()->isTypeID($typeID)) {
                $mItem->getBlueprint()->setME($me);
            }

            foreach ($mItem->getBlueprint()->getItems() as $cItem) {
                self::setME($cItem, $typeID, $me);
            }
        }
    }

    /**
     * @param MItem $mItem
     * @param int   $typeID
     * @param int   $te
     */
    public static function setTE(MItem $mItem, $typeID, $te)
    {
        if ($mItem->hasBlueprint()) {
            if ($mItem->getBlueprint()->isTypeID($typeID)) {
                $mItem->getBlueprint()->setTE($te);
            }

            foreach ($mItem->getBlueprint()->getItems() as $cItem) {
                self::setTE($cItem, $typeID, $te);
            }
        }
    }
}