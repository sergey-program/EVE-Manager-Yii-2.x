<?php

namespace app\modules\characters\controllers\extend;

use app\controllers\extend\AbstractController;

/**
 * Class AbstractCharactersController
 *
 * @package app\modules\characters\controllers\extend
 */
abstract class AbstractCharactersController extends AbstractController
{
    const REMEMBER_NAME = 'characters';

    public $layout = 'main';

    /**
     *
     */
    public function init()
    {
        $this
            ->getView()
            ->addBread(['label' => 'Characters', 'url' => ['/characters/index/index']]);
    }
}