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
        $invType = is_numeric($invType) ? InvTypes::findOne(['typeID' => $invType]) : $invType;

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
        $iap = IndustryActivityProducts::find()->where(['and', ['activityID' => '1'], ['productTypeID' => $invTypeID]])->one();

        if (!empty($iap)) {
            return new MBlueprint(InvTypes::findOne(['typeID' => $iap->typeID])); // bpo
        }

        return null;
    }

//    /**
//     * @param MItem $mItem
//     * @param int   $typeID
//     * @param int   $me
//     */
//    public static function setME(MItem $mItem, $typeID, $me)
//    {
//        if ($mItem->isTypeID($typeID)) {
//            $mItem->setME($me);
//        }
//
//        if ($mItem->hasComponents()) {
//            foreach ($mItem->getComponents() as $cItem) {
//                if ($cItem->isTypeID($typeID)) {
//                    $cItem->setME($me);
//                }
//            }
//        }
//    }
//
//    /**
//     * @param MItem $mItem
//     * @param int   $typeID
//     * @param int   $te
//     */
//    public static function setTE(MItem $mItem, $typeID, $te)
//    {
//        if ($mItem->isTypeID($typeID)) {
//            $mItem->setME($te);
//        }
//
//        if ($mItem->hasComponents()) {
//            foreach ($mItem->getComponents() as $cItem) {
//                if ($cItem->isTypeID($typeID)) {
//                    $cItem->setTE($te);
//                }
//            }
//        }
//    }
}