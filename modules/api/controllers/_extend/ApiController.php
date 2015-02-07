<?php

namespace app\modules\api\controllers\_extend;

use app\controllers\_extend\AbstractController;

abstract class ApiController extends AbstractController
{
    public $layout = 'main';

    public function init()
    {
        $this->addBread(['label' => 'Api']);
    }
}