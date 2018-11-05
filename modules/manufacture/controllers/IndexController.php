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
        $invType =InvTypes::findOne(['typeID'=> $typeID]);
        $item = $invType->getItem();

        return $this->render('view', ['item' => $item]);
    }



}