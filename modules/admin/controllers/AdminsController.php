<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15/11/2016
 * Time: 01:46
 */

namespace app\modules\admin\controllers;

use app\modules\admin\components\Controller;
use yii\db\Exception;
use yii\db\Expression;
use yii\web\HttpException;
use yii2vm\components\ModelException;
use yii2vm\db\ActiveUtils;

/**
 * Class AdminController
 * @package app\modules\admin\controllers
 */
class AdminsController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $userModel = new \app\modules\admin\models\User();
        $dataProvider = $userModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $userModel,
        ]);
    }
    
    public function actionAdd()
    {
        if (\Yii::$app->request->post()) {
            $user    = new \app\models\User();
            $post = \Yii::$app->request->post();
            $post['User']['created_at'] = new Expression('UTC_TIMESTAMP');
            $post['User']['password'] = \Yii::$app->security->generatePasswordHash(\Yii::$app->request->post('password'));
            $post['User']['ccess_token'] = \Yii::$app->security->generateRandomKey(32);
            $user->load($post);
            if ($user->validate() && $user->save()) {   
                return $this->redirect(['admins/index']);
            }else{
                 throw new ModelException($user);
            }
        };

        return $this->render('add');
    }
    public function actionEdit($id)
    {
        $data = \app\models\User::findOne((int)$id);
        if(\Yii::$app->request->post()){
            $post = \Yii::$app->request->post();
            if($post['User']['password'] != ''){
                $post['User']['password'] = \Yii::$app->security->generatePasswordHash($post['User']['password']);
            }else{
               $post['User']['password'] = $data->password; 
            }
            if ($data->load($post) && $data->save()) {
                return $this->redirect(['admins/index']);
            }
        }

        return $this->render('edit', [
            'model' => $data,
            'data' => $data,
        ]);
    }
    
    public function actionBulk(){
        $btnBulk = \Yii::$app->request->post('btnBulk');
        $action=\Yii::$app->request->post('action');
        $selection= \Yii::$app->request->post('selection');//typecasting
        $connection = \Yii::$app->getDb();
        if(count($selection) > 0){
            if($btnBulk == 'delete'){
                $command = $connection->createCommand("SET foreign_key_checks = 0;")->execute();;
                foreach($selection as $id){
                    $e= \app\models\User::findOne((int)$id);//make a typecasting
                    $e->delete();
                }
                $command = $connection->createCommand("SET foreign_key_checks = 1;")->execute();
            }elseif($btnBulk == 'edit'){
                return $this->redirect(['admins/edit?id='.$selection[0]]);
            }
        }elseif($btnBulk == 'add'){
            return $this->redirect(['admins/add']);
        }
        if($btnBulk == 'delete'){
            return $this->redirect(['admins/index']);
        }
    }
}