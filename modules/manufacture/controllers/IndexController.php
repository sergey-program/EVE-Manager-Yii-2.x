<?php

namespace app\modules\manufacture\controllers;

use app\models\dump\InvTypes;
use app\modules\manufacture\components\MManager;

class IndexController extends AbstractManufactureController
{
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

    public function actionView($typeID)
    {
        $mItem = MManager::createItem($typeID);

        if (\Yii::$app->request->isPost) {
//            echo '<pre>';
//            print_r(\Yii::$app->request->post());

            foreach (\Yii::$app->request->post() as $key => $data) {
                if (is_numeric($key)) {
                    if ($data['te']) {
                        MManager::setTE($mItem, $key, $data['te']);
                    }

                    if ($data['me']) {
                        MManager::setME($mItem, $key, $data['me']);
                    }
                }
            }

//            echo '</pre>';
        }


//        $mItem->getBlueprint()->setME(10);
//        foreach ($mItem->getBlueprint()->getItems() as $item) {
//            if ($item->hasBlueprint()) {
//                $item->getBlueprint()->setME(10);
//            }
//        }

        return $this->render('view', ['mItem' => $mItem]);
    }
}