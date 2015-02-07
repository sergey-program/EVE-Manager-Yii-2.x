<?php

return array(
    'name' => 'EVE Manager',
    'basePath' => SITE_PATH_PROTECTED,
    'layoutPath' => SITE_PATH_PROTECTED . 'views' . DS . '_layout',
    'import' => require(SITE_PATH_CONFIG . '_import.php'),
    'components' => array(
        'db' => require(SITE_PATH_CONFIG . '_db.php'),
        //
        'user' => array(
            'allowAutoLogin' => true
        ),
        //
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => require(SITE_PATH_CONFIG . '_routes.php')
        ),
        //
        'errorHandler' => array('errorAction' => 'error/show'),
        //
        'log' => array('class' => 'CLogRouter', 'routes' => array(array('class' => 'CWebLogRoute', 'levels' => 'error, warning')))
    ),
    //
    'params' => require(SITE_PATH_CONFIG . '_params.php'),
    'preload' => array('log')
);