<?php

$config = [
    'id' => 'main',
    'name' => 'EVE Manager',
    'charset' => 'UTF-8',
    'language' => 'en',
    'basePath' => FILE_PATH_ROOT,
    'bootstrap' => ['log'],
    'params' => require_once(FILE_PATH_CONFIG_ENV . '_param.php'),
    'defaultRoute' => 'index/index',
    'components' => [
        'actionRefine' => ['class' => \app\components\actions\ActionRefine::class],
        'actionReprocess' => ['class' => \app\components\actions\ActionReprocess::class],
        'actionManufacture' => ['class' => \app\components\actions\ActionManufacture::class],
        //
        'baseGroups' => [
            'class' => \app\modules\marketUpdater\components\BaseGroupsComponent::class
        ],
        'selectorOres' => [
            'class' => \app\components\selectors\OresComponent::class
        ],
        'mineralAsOre' => [
            'class' => \app\modules\calculators\components\MineralComponent::class
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'thousandSeparator' => ' ',
            'decimalSeparator' => '.'
        ],
        'db' => require_once(FILE_PATH_CONFIG_ENV . '_db.php'),
        'user' => [
            'class' => 'app\components\UserExtended',
            'identityClass' => 'app\components\UserIdentity',
            'enableAutoLogin' => true,
            'loginUrl' => ['auth/sign-in']
        ],
        'authManager' => require(FILE_PATH_CONFIG_ENV . '_auth.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require(FILE_PATH_CONFIG_ENV . '_routes.php')
        ],
        'request' => [
            'cookieValidationKey' => 'eVgiVONC78oRwFJZd7R379eOF9SeqoP7', // change salt manually
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
        //
        'manufacture' => 'app\modules\manufacture\ManufactureModule',
        'calculators' => 'app\modules\calculators\CalculatorsModule',
        'market-updater' => 'app\modules\marketUpdater\MarketUpdaterModule',
        'corporation' => 'app\modules\corporation\Module',
        'character' => 'app\modules\character\Module',
        'prices' => 'app\modules\prices\Module'
    ]
];

if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
}

return $config;
