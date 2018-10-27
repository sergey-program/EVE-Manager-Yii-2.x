<?php

namespace app\modules\manufacture\controllers;

use app\models\BlueprintSettings;
use app\models\dump\InvTypes;

class SettingsController extends AbstractManufactureController
{
    /**
     * Original item that came from url by typeID.
     *
     * @var InvTypes|null $item
     */
    private $item;

    public function actionIndex()
    {

    }

    /**
     * @param int $typeID // item, not bpo
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate($typeID)
    {
        $item = $this->detectItem($typeID);
        $this->getView()->setPageTitle($this->item->typeName);

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
     * @param int $typeID
     *
     * @return \app\components\items\Item|bool|false|null
     */
    private function detectItem($typeID)
    {
        $invType = InvTypes::findOne(['typeID' => $typeID]);
        $this->item = $invType->getItem();

        return $this->item->isBlueprint() ? $this->item->getProduct() : $this->item;
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
}