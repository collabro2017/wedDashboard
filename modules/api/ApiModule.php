<?php

namespace app\modules\api;

use Yii;
use yii2vm\api\Module;

class ApiModule extends Module
{
    public $controllerNamespace = 'app\modules\api\controllers';

    public function init()
    {
        parent::init();

        Yii::$app->components = [
            'user' => [
                'class'         => 'yii\web\User',
                'identityClass' => 'app\models\ext\Token',
            ],
        ];
    }
}
