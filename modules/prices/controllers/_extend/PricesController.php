<?php

namespace app\modules\prices\controllers\_extend;

use app\controllers\_extend\AbstractController;

abstract class PricesController extends AbstractController
{
    public $layout = 'main';

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->addBread(['label' => 'Prices', 'url' => ['/prices/index/index']]);
    }
}