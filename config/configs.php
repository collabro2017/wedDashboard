<?php
return [
    'develop' => [
        'default' => true,
        'options' => [
            'db' => [
                'dsn'                 => 'mysql:host=dev.voodoo.pub;dbname=wedo',
                'username'            => 'wedo',
                'password'            => 'f7M5FqMBpLbbMGxT',
                'charset'             => 'utf8',
                'enableSchemaCache'   => true,
                'schemaCacheDuration' => 3600,
                'schemaCache'         => 'cache',
            ],
        ]
    ],
    'production' => [
        'options' => [
            'db' => [
                'dsn'                 => 'mysql:host=localhost;dbname=wedowedd_web',
                'username'            => 'wedowedd_web',
                'password'            => 'u12m1qyFbigp',
                'charset'             => 'utf8',
                'enableSchemaCache'   => true,
                'schemaCacheDuration' => 3600,
                'schemaCache'         => 'cache',
            ],
        ]
    ],
];