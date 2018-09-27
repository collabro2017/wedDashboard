<?php

namespace app\modules\site\components;

use yii\filters\AccessControl;

class Controller extends \yii\web\Controller
{
    public $layout = 'main';

    public $breadcrumbs = [];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['sign-in'],
                        'roles'   => ['?'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['*'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }
}
