<?php

namespace app\modules\marketUpdater\controllers;

use app\components\updater\MarketGroup;
use app\models\dump\InvGroups;

/**
 * Class IndexController
 *
 * @package app\modules\marketUpdater\controllers
 */
class IndexController extends AbstractMarketUpdater
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $this
            ->getView()
            ->addBread('Market updater')
            ->setPageTitle('Market updater')
            ->setPageDescription('Setup what groups should be updated instantly.');

        $groups = InvGroups::find()->where(['groupID' => [18, 754, 1042, 465, 423]])->cache(60 * 60 * 24)->all();

        return $this->render('index', ['groups' => $groups]);
    }

    /**
     * @param int $groupID
     *
     * @return \yii\web\Response
     *
     * @throws \Exception
     */
    public function actionUpdateGroup($groupID)
    {
        MarketGroup::update($groupID);

        return $this->redirect('index');
    }
}