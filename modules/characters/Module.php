<?php

namespace app\modules\characters;

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