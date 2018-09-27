<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25/03/15
 * Time: 19:04
 */

namespace app\modules\couple\controllers;

use app\modules\couple\components\Controller;
use app\modules\couple\models\forms\ChangePasswordModel;
use app\modules\couple\models\Wedding;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii2vm\media\upload\ImageUpload;

/**
 * Class InfoController
 * @package app\modules\couple\controllers
 */
class InfoController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->breadcrumbs = [
            ['label' => 'WEDDING INFO']
        ];

        /** @var Wedding $model */
        $model = Wedding::current();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $size = (object)ArrayHelper::getValue(Yii::$app->params, 'welcome', []);
            ImageUpload::createFromEntity($model, 'welcome')
                       ->resize($size->width, $size->height)
                       ->toEntity($model, 'welcome_filename');

            $this->refresh();
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws \yii2vm\components\ModelException
     */
    public function actionClearData()
    {
        /** @var Wedding $wedding */
        $wedding = Wedding::current();
        $wedding->clearData();

        Yii::$app->session->setFlash('clear-data', 'All data has been successfully cleared');

        return $this->redirect('index');
    }

    /**
     * @return string | array
     */
    public function actionChangePassword()
    {
        $model = new ChangePasswordModel();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (!$model->validate() || !$model->save()) {
                return ActiveForm::validate($model);
            }
        }

        return $this->redirect(['index']);
    }
}