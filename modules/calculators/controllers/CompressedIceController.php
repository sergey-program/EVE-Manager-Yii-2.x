<?php

namespace app\modules\calculators\controllers;

use app\components\updater\MarketGroup;
use app\models\dump\InvGroups;

/**
 * Class CompressedIceController
 *
 * @package app\modules\calculators\controllers
 */
class CompressedIceController extends AbstractCalculatorsController
{
    public function actionIndex()
    {
        $this
            ->getView()
            ->addBread('Calculators')
            ->setPageTitle('Compressed ICE')
            ->setPageDescription('Calculate compressed ice prices.');

        $groups = InvGroups::find()->where(['groupID' => 465])->orderBy(['groupName' => 'ASC'])->all();

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