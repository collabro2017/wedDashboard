<?php

namespace app\modules\couple;

use app\modules\couple\models\Wedding;
use yii\base\Module;
use yii\web\User;

class CoupleModule extends Module
{
    public $controllerNamespace = 'app\modules\couple\controllers';

    public function init()
    {
        parent::init();

        $this->defaultRoute = 'info/index';
        // custom initialization code goes here

        \Yii::$app->components = [
            'user'    => [
                'class'           => User::className(),
                'identityClass'   => Wedding::className(),
                'idParam'         => 'wedo\couple',
                'enableAutoLogin' => true,
                'identityCookie'  => ['name' => 'couple', 'httpOnly' => true],
            ],
            'wedding' => [
                'class' => Wedding::className()
            ]
        ];

        \Yii::$app->user->loginUrl = ['/couple/default/sign-in'];
    }
}
