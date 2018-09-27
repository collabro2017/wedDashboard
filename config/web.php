<?php

use yii2vm\config\Configurator;

$params = require(__DIR__ . '/params.php');

$config = [
    'id'           => 'WeDo',
    'name'         => 'WeDo',
    'basePath'     => dirname(__DIR__),
    'bootstrap'    => ['log', 'configurator'],
    'defaultRoute' => 'couple/default/index',
    'components'   => [
        'formatter'    => [

        ],
        'configurator' => [
            'class'   => Configurator::className(),
            'configs' => require(__DIR__ . '/configs.php'),
        ],
        'request'      => [
            'cookieValidationKey' => 'MKJFeFPRh8He__Z4klOEcfY1BGgGRBfD',
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'assetManager' => [
            'linkAssets' => true,
        ],
        'authManager'  => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'urlManager'   => [
            'class'           => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                'uploads/<section>/<image>'              => 'uploads/stub',
                '<controller:\w+>/<id:\d+>'              => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
            ],
        ],
        'user'         => [
            'class'         => 'yii\web\User',
            'identityClass' => 'app\models\ext\Token',
        ],
        'api'          => [
            'class' => 'yii2vm\api\components\Api',
            'enableProfiling' => false
        ],
        'errorHandler' => [
            'errorAction' => 'couple/default/error',
        ],
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class'   => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/profile.log',
                    'levels'  => ['profile'],
                ],
            ],
        ],
        'db'           => [
            'class' => 'yii\db\Connection',
        ],
        'push'         => [
            'class'     => '\yii2vm\pushes\AmazonPushProvider',
            'accessKey' => 'AKIAJUUIA6IN4IHWGGWQ',
            'secretKey' => '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',
            'appArn'    => 'arn:aws:sns:us-east-1:606795181301:app/APNS/wedo.dev',
            'region'    => 'us-east-1',
        ]
    ],

    'modules' => [
        'api'    => [
            'class' => 'app\modules\api\ApiModule',
        ],
        'site'   => [
            'class' => 'app\modules\site\SiteModule',
        ],
        'couple' => [
            'class' => 'app\modules\couple\CoupleModule',
        ],
        'admin'  => [
            'class' => 'app\modules\admin\AdminModule',
        ],
    ],

    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
