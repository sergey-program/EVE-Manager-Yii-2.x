<?php

namespace app\modules\calculators\controllers;

/**
 * Class CompressedIceController
 *
 * @package app\modules\calculators\controllers
 */
class CompressedIceController extends AbstractCompressedController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $this
            ->getView()
            ->addBread('Calculators')
            ->setPageTitle('Compressed Ice')
            ->setPageDescription('Calculate compressed ice prices.');

        $groupIDs = [465];
        $items = $this->getGroupItems($groupIDs);

        return $this->render('index', ['items' => $items]);
    }
}