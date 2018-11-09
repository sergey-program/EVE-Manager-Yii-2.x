<?php

namespace app\modules\manufacture\controllers;

use app\models\dump\InvTypes;
use yii\helpers\Url;

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
        $invType = InvTypes::findOne(['typeID' => $typeID]);
        $item = $invType->getItem();

        \Yii::$app->session->set('lastViewedItemID', $typeID);

        return $this->render('view', ['item' => $item]);
    }
}