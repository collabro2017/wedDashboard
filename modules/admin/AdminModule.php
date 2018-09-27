<?php

namespace app\modules\admin;

class AdminModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';

    public function init()
    {
        parent::init();

        \Yii::$app->components = [
            'user' => [
                'class'           => '\yii\web\User',
                'identityClass'   => '\app\modules\admin\models\User',
                'idParam'         => 'wedo\admin',
                'enableAutoLogin' => true,
                'loginUrl'        => ['/admin/default/sign-in'],
                'identityCookie'  => ['name' => 'admin', 'httpOnly' => true],
            ],
        ];
    }
}
