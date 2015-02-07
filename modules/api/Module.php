<?php

namespace app\modules\api;

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