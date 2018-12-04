<?php

\Yii::setAlias('@tests', FILE_PATH_ROOT . '/tests');

$config = [
    'id' => 'main-console',
    'basePath' => FILE_PATH_ROOT,
    'bootstrap' => ['log'],
    'params' => require(FILE_PATH_CONFIG_ENV . '_param.php'),
    'controllerNamespace' => 'app\commands',
    'components' => [
        'actionRefine' => ['class' => \app\components\actions\ActionRefine::class],
        'actionReprocess' => ['class' => \app\components\actions\ActionReprocess::class],
        'actionManufacture' => ['class' => \app\components\actions\ActionManufacture::class],
        'actionUpdatePrice' => ['class' => \app\components\actions\ActionUpdatePrice::class],
        //
        'db' => require(FILE_PATH_CONFIG_ENV . '_db.php'),
        'authManager' => require(FILE_PATH_CONFIG_ENV . '_auth.php'),
        'cache' => [
            'class' => 'yii\caching\FileCache',
//            'class' => \yii\caching\MemCache::class,
//            'useMemcached' => true,
//            'servers' => [
//                ['host' => '127.0.0.1', 'port' => 11211]
//            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                ['class' => 'yii\log\FileTarget', 'levels' => ['error', 'warning']]
            ]
        ]
    ]
];

return $config;