<?php

namespace app\modules\character;

use app\modules\extend\AbstractModule;

/**
 * Class Module
 *
 * @package app\modules\character
 */
class Module extends AbstractModule
{
    /**
     *
     */
    public function init()
    {
        parent::init();

        \Yii::configure($this, [
            'modules' => [
                'market' => 'app\modules\character\modules\market\Module'
            ]
        ]);
    }
}