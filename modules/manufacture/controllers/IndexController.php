<?php

namespace app\modules\manufacture\controllers;

use app\models\BlueprintSettings;
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

        if (\Yii::$app->request->isPost) {
            $query = \Yii::$app->getRequest()->post('query');
            $invTypes = InvTypes::find()
                ->where([
                    'and',
                    ['like', 'typeName', $query],
                    ['published' => true],
                    ['not', ['groupID' => [1950, 1953, 1955]]],
                    ['not like', 'typeName', 'Blueprint'],
                    ['not like', 'typeName', 'Formula'],
                    ['not like', 'typeName', 'skin']
                ])
                ->orderBy('typeName')
                ->all();
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

                    if (is_numeric($data['meBonus'])) {
                        $attributes['meBonus'] = $data['meBonus'];
                    }

                    if (is_numeric($data['teBonus'])) {
                        $attributes['teBonus'] = $data['teBonus'];
                    }

                    $this->updateBlueprintSettings($key, $attributes);
                }
            }

            return $this->refresh();
        }

//        MManager::applyCitadelBonus($mItem, 3);
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
}