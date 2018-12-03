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
    /**
     * @return string
     */
    public function actionIndex()
    {
        $this
            ->getView()
            ->addBread('Calculators')
            ->setPageTitle('Compressed ICE')
            ->setPageDescription('Calculate compressed ice prices.');

        $group = InvGroups::find()->where(['groupID' => 465])->orderBy(['groupName' => 'ASC'])->one();

        return $this->render('index', ['group' => $group]);
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
        throw new \Exception('Not implemented');
//        MarketGroup::update($groupID);

        return $this->redirect('index');
    }
}