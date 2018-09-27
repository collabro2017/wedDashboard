<?php

namespace app\modules\admin\controllers;

use app\modules\admin\components\Controller;
use app\modules\admin\models\SignInModel;
use yii\filters\AccessControl;

/**
 * Class DefaultController
 * @package app\modules\admin\controllers
 */
class DefaultController extends Controller
{
    /**
     * @var string
     */
    public $layout = '@app/modules/admin/views/layouts/basic.php';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['sign-in'],
                        'roles'   => ['?'],
                    ],
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
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect(['weddings/index']);
    }

    /**
     * @return string
     */
    public function actionSignIn()
    {
        $this->view->params['body-class'] = 'login';

        $model = new SignInModel();
        if ($model->load(\Yii::$app->request->post()) && $model->signIn()) {
            return $this->redirect(['weddings/index']);
        };

        return $this->render('sign-in', [
            'model' => $model,
        ]);
    }
}