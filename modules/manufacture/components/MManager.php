<?php

namespace app\modules\manufacture\components;

use app\models\BlueprintSettings;
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
     * @param     $invType
     * @param int $quantity
     *
     * @return MItemMaterial
     */
    public static function createItemMaterial($invType, $quantity = 1)
    {
        if (is_numeric($invType)) {
            $invType = InvTypes::find()->where(['typeID' => $invType])->cache(60 * 60 * 24)->one();
        }

        return new MItemMaterial($invType, $quantity);
    }

    /**
     * Collect all blueprints that item uses for manufacture.
     *
     * @param MItem $mItem // not bpo
     * @param bool  $asTypeID
     *
     * @return array
     */
    public static function getAllBlueprints(AbstractItem $mItem, $asTypeID = true)
    {
        $result = [];

        if ($mItem->hasBlueprint()) {
            $invTypeID = $mItem->getBlueprint()->getInvType()->typeID;
            $result[$invTypeID] = $asTypeID ? $invTypeID : $mItem->getBlueprint();

            foreach ($mItem->getBlueprint()->getItems() as $cItem) {
                $result = array_merge($result, self::getAllBlueprints($cItem));
            }
        }

        return $result;
    }

    /**
     * Load user's blueprint settings and apply them.
     *
     * @param MItem $mItem // not bpo
     */
    public static function applyBlueprintSettings(AbstractItem $mItem)
    {
        $typeIDs = self::getAllBlueprints($mItem);
        // @todo select all blueprints before use them in foreach loop

        foreach ($typeIDs as $typeID) {
            $blueprintSettings = BlueprintSettings::findOne(['typeID' => $typeID, 'userID' => \Yii::$app->user->id]);

            if ($blueprintSettings) {
                $me = $blueprintSettings->me ? $blueprintSettings->me : 0;
                $meHull = $blueprintSettings->meHull ? $blueprintSettings->meHull : 0;
                self::setME($mItem, $blueprintSettings->typeID, $me, $meHull);

                $te = $blueprintSettings->te ? $blueprintSettings->te : 0;
                $teBonus = $blueprintSettings->teHull ? $blueprintSettings->teHull : 0;
                self::setTE($mItem, $blueprintSettings->typeID, $te, $teBonus);

                $runPrice = $blueprintSettings->runPrice ? $blueprintSettings->runPrice: 0;
                self::setRunPrice($mItem, $blueprintSettings->typeID, $runPrice);
            }
        }

        // @todo refactor, add me\te\runPrice
    }

    public static function applyCitadelBonus(AbstractItem $mItem, $bonus)
    {
        if ($mItem->hasBlueprint()) {
            $mItem->getBlueprint()->setmeHull($bonus);

            foreach ($mItem->getBlueprint()->getItems() as $item) {
                self::applyCitadelBonus($item, $bonus);
            }
        }
    }

    /**
     * @param MItem $mItem // not bpo
     * @param int   $quantity
     *
     * @return MTotal
     */
    public static function calculateTotal(AbstractItem $mItem, $quantity = 1)
    {
        return new MTotal($mItem, $quantity);
    }

    /**
     * @param MItem $mItem // not bpo
     * @param int   $typeID
     * @param int   $me
     * @param int   $meHull
     */
    public static function setME(AbstractItem $mItem, $typeID, $me, $meHull = 0)
    {
        if ($mItem->hasBlueprint()) {
            if ($mItem->getBlueprint()->isTypeID($typeID)) {
                $mItem->getBlueprint()->setME($me);
                $mItem->getBlueprint()->setMeHull($meHull);
            }

            foreach ($mItem->getBlueprint()->getItems() as $cItem) {
                self::setME($cItem, $typeID, $me, $meHull);
            }
        }
    }

    /**
     * @param MItem $mItem // not bpo
     * @param int   $typeID
     * @param int   $te
     * @param int   $teBonus
     */
    public static function setTE(AbstractItem $mItem, $typeID, $te, $teBonus = 0)
    {
        if ($mItem->hasBlueprint()) {
            if ($mItem->getBlueprint()->isTypeID($typeID)) {
                $mItem->getBlueprint()->setTE($te);
//                $mItem->getBlueprint()->setTeBonus($teBonus);
            }

            foreach ($mItem->getBlueprint()->getItems() as $cItem) {
                self::setTE($cItem, $typeID, $te, $teBonus);
            }
        }
    }

    public static function setRunPrice(AbstractItem $mItem, $typeID, $runPrice)
    {
        if ($mItem->hasBlueprint()) {
            if ($mItem->getBlueprint()->isTypeID($typeID)) {
                $mItem->getBlueprint()->setRunPrice($runPrice);
            }

            foreach ($mItem->getBlueprint()->getItems() as $cItem) {
                self::setRunPrice($cItem, $typeID, $runPrice);
            }
        }
    }
}