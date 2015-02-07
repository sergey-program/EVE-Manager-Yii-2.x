<?php

namespace app\modules\character;

use app\modules\_extend\AbstractModule;

class Module extends AbstractModule
{
    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->loadConfig();
    }
}