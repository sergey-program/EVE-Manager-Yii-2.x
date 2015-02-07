<?php

namespace app\controllers\_extend;

use Yii;

/**
 * Class BackendController
 *
 * @package app\controllers\_extend
 */
abstract class BackendController extends AbstractController
{
    public $layout = 'backend';
}