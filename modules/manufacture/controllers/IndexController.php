<?php

namespace app\modules\manufacture\controllers;

use app\models\dump\InvTypes;

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
        $items = [];
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

            $items = InvTypes::findItems($filter);
        }

        return $this->render('index', [
            'items' => $items,
            'lastItems' => \Yii::$app->lastOpenedItems->getItems() // @todo this is only module component
        ]);
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
        \Yii::$app->lastOpenedItems->addTypeID($typeID);

        return $this->render('view', ['item' => $item]);
    }
}