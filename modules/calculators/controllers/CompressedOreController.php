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
            ->addBread('Market updater')
            ->setPageTitle('Market updater')
            ->setPageDescription('Market updater');

        $groups = InvGroups::findAll(['groupID' => [462, 460, 450, 458]]);

        return $this->render('index', ['groups' => $groups]);
    }
}