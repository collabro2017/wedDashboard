<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15/11/2016
 * Time: 00:26
 */

namespace app\modules\admin\components;

use yii\filters\AccessControl;

/**
 * Class Controller
 * @package app\modules\admin\components
 */
class Controller extends \yii\web\Controller
{
    /**
     * @var string
     */
    public $layout = '@app/modules/admin/views/layouts/main.php';

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
                    ],
                ],
            ],
        ];
    }

    /**
     * @param \yii\base\Action $action
     *
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->view->params['body-class'] = 'nav-md';

        return parent::beforeAction($action);
    }

}