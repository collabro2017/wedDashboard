<?php

use yii2vm\config\Configurator;

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');

return [
    'id'                  => 'basic-console',
    'name'                => 'WeDo',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log', 'configurator', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules'             => [
        'gii' => 'yii\gii\Module',
    ],
    'components'          => [
        'configurator' => [
            'class'   => Configurator::className(),
            'configs' => require(__DIR__ . '/configs.php'),
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'log'          => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => [
            'class' => 'yii\db\Connection',
        ]
    ],
    'params'              => $params,
];
