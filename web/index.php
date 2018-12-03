<?php

use yii\web\Application;

define('DS', DIRECTORY_SEPARATOR);
define('FILE_PATH_ROOT_WEB', __DIR__ . DS);
define('FILE_PATH_ROOT', FILE_PATH_ROOT_WEB . '..' . DS);
define('FILE_PATH_VENDOR', FILE_PATH_ROOT . 'vendor' . DS);

$env = 'test';
$env = file_exists(FILE_PATH_ROOT . '.prod') ? 'prod' : $env;
$env = file_exists(FILE_PATH_ROOT . '.dev') ? 'dev' : $env;
defined('YII_ENV') or define('YII_ENV', $env);

$debug = file_exists(FILE_PATH_ROOT . '.debug') ? true : false;
$debug = in_array(YII_ENV, ['test', 'dev']) ? true : $debug;
defined('YII_DEBUG') or define('YII_DEBUG', $debug);

require(FILE_PATH_VENDOR . 'autoload.php');
require(FILE_PATH_VENDOR . 'yiisoft' . DS . 'yii2' . DS . 'Yii.php');

define('FILE_PATH_CONFIG', FILE_PATH_ROOT . 'config' . DS);
define('FILE_PATH_CONFIG_ENV', FILE_PATH_CONFIG . YII_ENV . DS);

$configPath = require(FILE_PATH_CONFIG_ENV . 'main.php');

if (!YII_ENV_PROD) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}


$application = new Application($configPath);
$application->run();