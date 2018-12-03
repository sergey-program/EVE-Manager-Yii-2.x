<?php

namespace app\modules\marketUpdater\controllers;

use app\components\actions\ActionUpdatePrice;
use app\models\dump\InvTypes;
use app\models\MarketPriceSchedule;
use yii\helpers\ArrayHelper;

/**
 * Class IndexController
 *
 * @package app\modules\marketUpdater\controllers
 */
class IndexController extends AbstractMarketUpdater
{
    const SESSION_SEARCH_STRING = 'session_search_string';

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this
            ->getView()
            ->addBread('Item Price Updater')
            ->setPageTitle('Item Price Updater')
            ->setPageDescription('Setup what item prices should be updated automatically.');

        $marketPriceSchedules = MarketPriceSchedule::find()->orderBy(['timeUpdated' => SORT_ASC])->all();

        $searchString = $this->get('searchString');
        $searchItems = [];

        if ($searchString) {
            \Yii::$app->session->set(self::SESSION_SEARCH_STRING, $searchString);

            $invTypes = InvTypes::find()
                ->where([
                    'or',
                    ['like', 'typeName', $searchString],
                    ['typeID' => $searchString]
                ])
                ->andWhere(['and',
                    ['published' => true],
                    'typeName NOT LIKE "%blueprint%"',
                    'typeName NOT LIKE "% skin %"',
                    'typeName NOT LIKE "% suit %"',
                    'typeName NOT LIKE "% pants %"',
                    'typeName NOT LIKE "% t-shirt %"',
                    'typeName NOT LIKE "% skirt %"',
                    'typeName NOT LIKE "% boots %"',
                    ['not', ['typeID' => ArrayHelper::getColumn($marketPriceSchedules, 'typeID')]]
                ])
                ->all();

            if (!empty($invTypes)) {
                foreach ($invTypes as $invType) {
                    $searchItems[] = $invType->getItem();
                }
            }
        }

//        /** @var BaseGroupsComponent $baseGroups */
//        $baseGroups = \Yii::$app->baseGroups;
//        $invGroups = $baseGroups->getInvGroups();

//        if (\Yii::$app->request->isPost) {
//            $groupID = \Yii::$app->request->post('groupID');
//
//            if ($groupID) {
//                if (!MarketUpdateGroup::findOne(['groupID' => $groupID])) {
//                    $mug = new MarketUpdateGroup(['groupID' => $groupID]);
//
//                    if ($mug->save()) {
//                        return $this->refresh();
//                    }
//                }
//            }
//        }

        return $this->render('index', [
            'marketPriceSchedules' => $marketPriceSchedules,
            'searchItems' => $searchItems
        ]);
    }

    /**
     * @param int $typeID
     *
     * @return \yii\web\Response
     */
    public function actionUpdate($typeID)
    {
        /** @var ActionUpdatePrice $actionUpdatePrice */
        $actionUpdatePrice = \Yii::$app->actionUpdatePrice;
        $actionUpdatePrice->update($typeID);
        return $this->redirect(['index', 'searchString' => \Yii::$app->session->get(self::SESSION_SEARCH_STRING)]);
    }

    /**
     * @param int $typeID
     *
     * @return \yii\web\Response
     */
    public function actionAdd($typeID)
    {
        /** @var MarketPriceSchedule $entry */
        $marketPriceSchedule = new MarketPriceSchedule(['typeID' => $typeID]);
        $marketPriceSchedule->save();
        return $this->redirect(['index', 'searchString' => \Yii::$app->session->get(self::SESSION_SEARCH_STRING)]);
    }

    /**
     * @param int $typeID
     *
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($typeID)
    {
        $entry = MarketPriceSchedule::findOne(['typeID' => $typeID]);
        if ($entry) {
            $entry->delete();
        }
        return $this->redirect(['index', 'searchString' => \Yii::$app->session->get(self::SESSION_SEARCH_STRING)]);
    }
}