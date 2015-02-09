<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class Select2Asset
 *
 * @package app\assets
 */
class Select2Asset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'js/select2-3.4.8/select2.css',
        'js/select2-3.4.8/select2-bootstrap.css'
    ];
    public $js = [
        'js/select2-3.4.8/select2.js'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset'
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
}
