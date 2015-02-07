<?php

Yii::setAlias('@tests', FILE_PATH_ROOT . '/tests');

$aConfig = [
    'id' => 'main-console',
    'basePath' => FILE_PATH_ROOT,
//    'bootstrap' => ['log', 'gii'],
    'bootstrap' => ['log'],
    'params' => require(FILE_PATH_CONFIG_ENV . '_param.php'),
    'controllerNamespace' => 'app\commands',
    'components' => [
        'db' => require(FILE_PATH_CONFIG_ENV . '_db.php'),
        //'authManager' => require(FILE_PATH_CONFIG_ENV . '_auth.php'),
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning']
                ]
            ]
        ]
    ],
    //'modules' => ['gii' => 'yii\gii\Module']
];

return $aConfig;