<?php

use yii\web\Application;

define ('DS', DIRECTORY_SEPARATOR);
define('FILE_PATH_ROOT_WEB', __DIR__ . DS);
define('FILE_PATH_ROOT', FILE_PATH_ROOT_WEB . '..' . DS);
define('FILE_PATH_ROOT_UPLOAD', FILE_PATH_ROOT_WEB . DS . 'uploads' . DS);
define('FILE_PATH_VENDOR', FILE_PATH_ROOT . 'vendor' . DS);

defined('YII_ENV') or define('YII_ENV', file_exists(FILE_PATH_ROOT . '.production') ? 'prod' : 'dev');
defined('YII_DEBUG') or define('YII_DEBUG', YII_ENV === 'dev');

define('FILE_PATH_CONFIG', FILE_PATH_ROOT . 'config' . DS);
define('FILE_PATH_CONFIG_ENV', FILE_PATH_CONFIG . YII_ENV . DS);

require(FILE_PATH_VENDOR . 'autoload.php');
require(FILE_PATH_VENDOR . 'yiisoft' . DS . 'yii2' . DS . 'Yii.php');

$aConfig = require(FILE_PATH_CONFIG_ENV . 'main_site.php');

$oApplication = new Application($aConfig);
$oApplication->run();