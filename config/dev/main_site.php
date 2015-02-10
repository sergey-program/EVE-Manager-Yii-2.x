<?php

$aConfig = [
    'id' => 'main',
    'name' => 'EVE Manager 2',
    'charset' => 'UTF-8',
    'language' => 'ru',
    'basePath' => FILE_PATH_ROOT,
    'bootstrap' => [
        'log'
    ],
    'params' => require_once(FILE_PATH_CONFIG_ENV . '_param.php'),
    'defaultRoute' => 'index/index',
    'components' => [
        'db' => require_once(FILE_PATH_CONFIG_ENV . '_db.php'),
        'user' => [
            'class' => 'app\components\UserExtended',
            'identityClass' => 'app\objects\UserIdentity',
            'enableAutoLogin' => true,
            'loginUrl' => ['auth/login']
        ],
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
        'errorHandler' => [
            'errorAction' => 'error/index',
        ],
        'view' => [
            'class' => 'app\components\ViewExtended'
        ],
        // send all mails to a file by default. You have to set
        // 'useFileTransport' to false and configure a transport
        // for the mailer to send real emails.
        //'mailer' => ['class' => 'yii\swiftmailer\Mailer','useFileTransport' => true,],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [['class' => 'yii\log\FileTarget', 'levels' => ['error', 'warning']]],
        ]
    ],
    'modules' => [
        'debug' => 'yii\debug\Module',
        'api' => 'app\modules\api\Module',
        'characters' => 'app\modules\characters\Module',
        'character' => 'app\modules\character\Module',
        'station' => 'app\modules\station\Module',
        'prices' => 'app\modules\prices\Module'
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $aConfig['bootstrap'][] = 'debug';
    $aConfig['modules']['debug'] = 'yii\debug\Module';
}

return $aConfig;
