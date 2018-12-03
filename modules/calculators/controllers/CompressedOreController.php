<?php

namespace app\modules\calculators\controllers;

use app\components\updater\MarketGroup;
use app\models\dump\InvGroups;

/**
 * Class CompressedOreController
 *
 * @package app\modules\calculators\controllers
 */
class CompressedOreController extends AbstractCalculatorsController
{
    public function actionIndex()
    {
        $this
            ->getView()
            ->addBread('Calculators')
            ->setPageTitle('Compressed Ore')
            ->setPageDescription('Calculate compressed ore prices.');

        $groupIDs = [450, 451, 452, 453, 454, 455, 456, 457, 458, 459, 460, 461, 462, 467, 469, 468];
        $groups = InvGroups::find()->where(['groupID' => $groupIDs])->orderBy(['groupName' => 'ASC'])->all();

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
        throw new \Exception('Not implemented');
//        MarketGroup::update($groupID);

        return $this->redirect('index');
    }
}