<?php

namespace app\modules\manufacture\controllers;

use app\models\BlueprintSettings;
use app\models\CompressSettings;
use app\models\dump\InvTypes;

/**
 * Class SettingsController
 *
 * @package app\modules\manufacture\controllers
 */
class SettingsController extends AbstractManufactureController
{
    /**
     * @param int $typeID // item, not bpo
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate($typeID)
    {
        $invType = InvTypes::findOne(['typeID' => $typeID]);
        $item = $invType->getItem(); // original item from url
        $this->getView()->setPageTitle($item->typeName);

        if ($item->isBlueprint()) {
            $item = $item->getProduct();
        }

        if (\Yii::$app->request->isPost) { // @todo refactor this one
            foreach (\Yii::$app->request->post() as $key => $data) {
                if (is_numeric($key)) {
                    $attributes = null;

                    if (is_numeric($data['me'])) {
                        $attributes['me'] = $data['me'];
                    }

                    if (is_numeric($data['te'])) {
                        $attributes['te'] = $data['te'];
                    }

                    if (is_numeric($data['meHull'])) {
                        $attributes['meHull'] = $data['meHull'];
                    }

                    if (is_numeric($data['teHull'])) {
                        $attributes['teHull'] = $data['teHull'];
                    }

                    if (is_numeric($data['meRig'])) {
                        $attributes['meRig'] = $data['meRig'];
                    }

                    if (is_numeric($data['teRig'])) {
                        $attributes['teRig'] = $data['teRig'];
                    }

                    if (is_numeric($data['runPrice'])) {
                        $attributes['runPrice'] = $data['runPrice'];
                    }

                    $this->updateBlueprintSettings($key, $attributes);
                }
            }

            return $this->refresh();
        }

        return $this->render('update', [
            'item' => $item,
            'bpo' => $item->getBlueprint()
        ]);
    }

    /**
     * @param int        $typeID
     * @param array|null $attributes
     *
     * @return bool
     */
    private function updateBlueprintSettings($typeID, $attributes)
    {
        if (empty($attributes)) {
            return false;
        }

        $filter = ['userID' => \Yii::$app->user->id, 'typeID' => $typeID];
        $blueprintSettings = BlueprintSettings::findOne($filter);
        $blueprintSettings->setAttributes($attributes);

        return $blueprintSettings->save();
    }

    public function actionCompressedOre($typeID){
        $invType = InvTypes::findOne(['typeID' => $typeID]);
        $item = $invType->getItem(); // original item from url
        $this->getView()->setPageTitle($item->typeName);

        if ($item->isBlueprint()) {
            $item = $item->getProduct();
        }

        if (\Yii::$app->request->isPost){
            $cs = CompressSettings::findOne(['userID' => \Yii::$app->user->id, 'mineralTypeID' => $mineralTypeID]);

            if ($cs) {
                if ($cs->oreTypeID == $oreTypeID) {
                    // do something?
                } else {
                    $cs->oreTypeID = $oreTypeID;
                }
            } else {
                $cs = new CompressSettings();
                $cs->userID = \Yii::$app->user->id;
                $cs->mineralTypeID = $mineralTypeID;
                $cs->oreTypeID = $oreTypeID;
            }

            $cs->save();

            return $this->redirect(['index/view', 'typeID' => $typeID]);
        }

        return $this->redirect(['index/view', 'typeID'=> $item->typeID]);
    }


//    /**
//     * @param int      $typeID
//     * @param int      $mineralTypeID
//     * @param int|null $oreTypeID
//     *
//     * @return \yii\web\Response
//     */
//    public function actionSetOre($typeID, $mineralTypeID, $oreTypeID = null)
//    {
//
//    }
}