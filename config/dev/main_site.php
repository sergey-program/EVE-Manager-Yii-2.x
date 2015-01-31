<?php

$aConfig = [
    'id' => 'EVE Manager 2',
    'basePath' => FILE_PATH_ROOT,
    'bootstrap' => ['log'],
    'params' => require_once(FILE_PATH_CONFIG_ENV . '_param.php'),
    'defaultRoute' => 'index/index',
    'components' => [
        'db' => require_once(FILE_PATH_CONFIG_ENV . '_db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require(FILE_PATH_CONFIG_ENV . '_routes.php')
        ],
        'request' => [
            'cookieValidationKey' => 'eVgiVONC78oRwFJZd7R379eOF9SeqoP7',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'error/index',
        ],
        // send all mails to a file by default. You have to set
        // 'useFileTransport' to false and configure a transport
        // for the mailer to send real emails.
        //'mailer' => ['class' => 'yii\swiftmailer\Mailer','useFileTransport' => true,],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [['class' => 'yii\log\FileTarget', 'levels' => ['error', 'warning']]],
        ]
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $aConfig['bootstrap'][] = 'debug';
    $aConfig['modules']['debug'] = 'yii\debug\Module';
}

return $aConfig;
