<?php

namespace app\modules\prices\controllers\extend;

use app\controllers\extend\AbstractController;

/**
 * Class AbstractPricesController
 *
 * @package app\modules\prices\controllers\extend
 */
abstract class AbstractPricesController extends AbstractController
{
    const REMEMBER_NAME = 'prices';

    public $layout = 'main';

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this
            ->getView()
            ->addBread(['label' => 'Prices', 'url' => ['/prices/index/index']]);
    }
}