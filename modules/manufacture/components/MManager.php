<?php

namespace app\modules\manufacture\components;

use app\models\BlueprintSettings;
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
            return new MBlueprint(InvTypes::find()->where(['typeID' => $iap->typeID])->cache(60 * 2)->one()); // bpo
        }

        return null;
    }

    /**
     * Collect all blueprints that item uses for manufacture.
     *
     * @param MItem $mItem // not bpo
     * @param bool  $asTypeID
     *
     * @return array
     */
    public static function getAllBlueprints(MItem $mItem, $asTypeID = true)
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
    public static function applyBlueprintSettings(MItem $mItem)
    {
        $typeIDs = self::getAllBlueprints($mItem);
        // @todo select all blueprints before use them in foreach loop

        foreach ($typeIDs as $typeID) {
            $blueprintSettings = BlueprintSettings::findOne(['typeID' => $typeID, 'userID' => \Yii::$app->user->id]);

            if ($blueprintSettings) {
                self::setME($mItem, $blueprintSettings->typeID, $blueprintSettings->me ? $blueprintSettings->me : 0);
                self::setTE($mItem, $blueprintSettings->typeID, $blueprintSettings->te ? $blueprintSettings->te : 0);
            }
        }
    }

    /**
     * @param MItem $mItem // not bpo
     * @param int   $quantity
     *
     * @return MTotal
     */
    public static function calculateTotal(MItem $mItem, $quantity = 1)
    {
        return new MTotal($mItem, $quantity);
    }

    /**
     * @param MItem $mItem // not bpo
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
     * @param MItem $mItem // not bpo
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