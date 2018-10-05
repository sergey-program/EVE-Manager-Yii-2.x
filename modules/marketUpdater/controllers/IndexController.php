<?php

namespace app\modules\marketUpdater\controllers;

use app\components\updater\MarketGroup;
use app\models\MarketUpdateGroup;
use app\modules\marketUpdater\components\BaseGroupsComponent;

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
            ->addBread('Group Updater')
            ->setPageTitle('Group Updater')
            ->setPageDescription('Setup what groups should be updated automatically.');

        /** @var BaseGroupsComponent $baseGroups */
        $baseGroups = \Yii::$app->baseGroups;
        $invGroups = $baseGroups->getInvGroups();

        if (\Yii::$app->request->isPost) {
            $groupID = \Yii::$app->request->post('groupID');

            if ($groupID) {
                if (!MarketUpdateGroup::findOne(['groupID' => $groupID])) {
                    $mug = new MarketUpdateGroup(['groupID' => $groupID]);

                    if ($mug->save()) {
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('index', ['groups' => $invGroups]);
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

    /**
     * @param int $groupID
     *
     * @return \yii\web\Response
     *
     * @throws \Throwable|\yii\db\StaleObjectException
     */
    public function actionDelete($groupID)
    {
        /** @var MarketUpdateGroup|null $mug */
        $marketUpdateGroup = MarketUpdateGroup::find()->where(['groupID' => $groupID])->one();

        if ($marketUpdateGroup) {
            $marketUpdateGroup->delete();
        }

        return $this->redirect(['index']);
    }
}