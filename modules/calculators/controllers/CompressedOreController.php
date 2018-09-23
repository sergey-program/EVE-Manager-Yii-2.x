<?php

namespace app\modules\calculators\controllers;

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

        $groups = InvGroups::findAll(['groupID' => [462, 460, 450, 458]]);

        return $this->render('index', ['groups' => $groups]);
    }
}