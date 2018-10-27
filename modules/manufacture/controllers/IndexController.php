<?php

namespace app\modules\manufacture\controllers;

use app\models\BlueprintSettings;
use app\models\CompressSettings;
use app\models\dump\InvTypes;
use app\modules\manufacture\components\MManager;

/**
 * Class IndexController
 *
 * @package app\modules\manufacture\controllers
 */
class IndexController extends AbstractManufactureController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $invTypes = [];

        $string = \Yii::$app->getRequest()->get('query');

        if ($string) {
            $filter = [
                'and',
                ['like', 'typeName', $string],
                ['published' => true],
                ['not', ['groupID' => [1950, 1953, 1955]]],
                ['not like', 'typeName', 'Blueprint'],
                ['not like', 'typeName', 'Formula'],
                ['not like', 'typeName', 'skin']
            ];

            $invTypes = InvTypes::find()->where($filter)->orderBy('typeName')->all();
        }

        return $this->render('index', ['invTypes' => $invTypes]);
    }

    /**
     * @param int $typeID
     *
     * @return string
     */
    public function actionView($typeID)
    {
        $mItem = MManager::createItem($typeID);

        if (\Yii::$app->request->isPost) {
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

        MManager::applyBlueprintSettings($mItem);

        return $this->render('view', ['mItem' => $mItem]);
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

        if (!$blueprintSettings) {
            $blueprintSettings = new BlueprintSettings($filter);
        }

        $blueprintSettings->setAttributes($attributes);

        return $blueprintSettings->save();
    }

    /**
     * @param int      $typeID
     * @param int      $mineralTypeID
     * @param int|null $oreTypeID
     *
     * @return \yii\web\Response
     */
    public function actionSetOre($typeID, $mineralTypeID, $oreTypeID = null)
    {
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
}