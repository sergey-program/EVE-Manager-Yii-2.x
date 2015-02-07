<?php

namespace app\modules\character\controllers\_extend;

use app\controllers\_extend\AbstractController;

abstract class CharacterController extends AbstractController
{
    public $layout = 'main';

    /**
     *
     */
    public function init()
    {
        $this->addBread(['label' => 'Character']);
    }
}