<?php

namespace app\modules\calculators\controllers;

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

        // @todo add settings for reprocess list
        $group = InvGroups::find()->where(['groupID' => 465])->orderBy(['groupName' => 'ASC'])->one();

        return $this->render('index', ['group' => $group]);
    }
}