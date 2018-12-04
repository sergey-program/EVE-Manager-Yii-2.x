<?php

namespace app\modules\calculators\controllers;

/**
 * Class CompressedOreController
 *
 * @package app\modules\calculators\controllers
 */
class CompressedOreController extends AbstractCompressedController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $this
            ->getView()
            ->addBread('Calculators')
            ->setPageTitle('Compressed Ore')
            ->setPageDescription('Calculate compressed ore prices.');

        $groupIDs = [450, 451, 452, 453, 454, 455, 456, 457, 458, 459, 460, 461, 462, 467, 469, 468];
        $items = $this->getGroupItems($groupIDs);

        return $this->render('index', ['items' => $items]);
    }
}