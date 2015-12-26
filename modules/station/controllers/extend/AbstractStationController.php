<?php

namespace app\modules\station\controllers\extend;

use app\controllers\extend\AbstractController;

/**
 * Class AbstractStationController
 *
 * @package app\modules\station\controllers\_extend
 */
abstract class AbstractStationController extends AbstractController
{
    const REMEMBER_NAME = 'station';

    public $layout = 'main';

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->getView()->addBread([
            'label' => 'Station',
            'url' => '/station/index/index'
        ]);
    }
}
