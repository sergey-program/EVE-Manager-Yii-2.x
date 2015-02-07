<?php

namespace app\controllers\_extend;

use Yii;

/**
 * Class FrontendController
 *
 * @package app\controllers\_extend
 */
abstract class FrontendController extends AbstractController
{
    public $layout = 'frontend';
}