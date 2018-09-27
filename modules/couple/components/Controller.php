<?php

namespace app\modules\couple\components;

use yii\filters\AccessControl;

/**
 * Class Controller
 * @package app\modules\couple\components
 */
class Controller extends \yii\web\Controller
{
    /**
     * @var string
     */
    public $layout = 'main';

    /**
     * @var array
     */
    public $breadcrumbs = [];

    /**
     * @return array
     */
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
                        'allow' => false,
                        'roles' => ['*'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $action
     *
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }
}
