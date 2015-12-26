<?php

namespace app\modules\character\modules\market\controllers;

use app\modules\character\modules\market\controllers\extend\AbstractMarketController;

/**
 * Class IndexController
 *
 * @package app\modules\character\modules\market\controllers
 */
class IndexController extends AbstractMarketController
{
    /**
     * @param int $characterID
     *
     * @return string
     */
    public function actionIndex($characterID)
    {
        $this
            ->getView()
            ->addBread('Index')
            ->setCharacter($this->loadCharacter($characterID));;

        return $this->render('index');
    }
}