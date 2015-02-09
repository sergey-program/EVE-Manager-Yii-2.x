<?php

namespace app\modules\station\controllers\_extend;

use app\controllers\_extend\AbstractController;

abstract class StationController extends AbstractController
{
    public $layout = 'main';

    /**
     *
     */
    public function init()
    {
        $this->addBread(['label' => 'Station']);
    }
}
