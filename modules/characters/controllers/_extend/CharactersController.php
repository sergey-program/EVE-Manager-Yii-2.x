<?php

namespace app\modules\characters\controllers\_extend;

use app\controllers\_extend\AbstractController;

abstract class CharactersController extends AbstractController
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