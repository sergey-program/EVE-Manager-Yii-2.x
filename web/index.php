<?php

use yii\web\Application;

define('DS', DIRECTORY_SEPARATOR);
define('FILE_PATH_ROOT_WEB', __DIR__ . DS);
define('FILE_PATH_ROOT', FILE_PATH_ROOT_WEB . '..' . DS);
define('FILE_PATH_ROOT_UPLOAD', FILE_PATH_ROOT_WEB . DS . 'uploads' . DS);
define('FILE_PATH_VENDOR', FILE_PATH_ROOT . 'vendor' . DS);

// default (local) env is 'test'
$env = 'test';
$env = file_exists(FILE_PATH_ROOT . '.prod') ? 'prod' : $env;
$env = file_exists(FILE_PATH_ROOT . '.dev') ? 'dev' : $env;
defined('YII_ENV') or define('YII_ENV', $env);

// on dev and test env enable debug
$debug = file_exists(FILE_PATH_ROOT . '.debug') ? true : false;
$debug = (YII_ENV == 'dev' || YII_ENV == 'test') ? true : $debug;
defined('YII_DEBUG') or define('YII_DEBUG', $debug);

define('FILE_PATH_CONFIG', FILE_PATH_ROOT . 'config' . DS);
define('FILE_PATH_CONFIG_ENV', FILE_PATH_CONFIG . YII_ENV . DS);

if ($env != 'prod' || $debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

require(FILE_PATH_VENDOR . 'autoload.php');
require(FILE_PATH_VENDOR . 'yiisoft' . DS . 'yii2' . DS . 'Yii.php');

$config = require(FILE_PATH_CONFIG_ENV . 'main.php');

$application = new Application($config);
$application->run();