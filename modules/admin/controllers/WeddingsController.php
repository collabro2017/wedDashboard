<?php

namespace app\modules\admin\controllers;

use app\models\ext\Wedding;
use app\models\WeddingDrink;
use app\modules\admin\models\WeddingSearchModel;
use app\modules\admin\components\Controller;
use dosamigos\editable\EditableAction;
use yii\data\ActiveDataProvider;

/**
 * Class WeddingsController
 * @package modules\admin\controllers
 */
class WeddingsController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'editable' => [
                'class'      => EditableAction::className(),
                'modelClass' => Wedding::className(),
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $weddingModel = new WeddingSearchModel();
        $dataProvider = $weddingModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $weddingModel,
        ]);
    }
    public function actionEdit($id)
    {
        $data= Wedding::findOne((int)$id);
        if ($data->load(\Yii::$app->request->post()) && $data->save()) {
            return $this->redirect(['weddings/index']);
        };

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
                    $e= Wedding::findOne((int)$id);//make a typecasting
                    //do your stuff
                    $oModel = WeddingDrink::findOne(['drink_category_id' => $id]);
                    if(isset($oModel)){
                        $oModel->delete();
                    }
                    $e->delete();
                }
                $command = $connection->createCommand("SET foreign_key_checks = 1;")->execute();
            }elseif($btnBulk == 'download'){
                $filename = 'Data-'.Date('YmdGis').'-Wedding.xls';
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=".$filename);
                echo '<table border="1" width="100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Bride</th>
                            <th>Groom</th>
                            <th>Email</th>
                            <th>Wedding Date</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Country</th>
                        </tr>
                    </thead>';
                    foreach($selection as $id){
                    $data= Wedding::findOne((int)$id);
                        echo '
                            <tr>
                                <td>'.$data['id'].'</td>
                                <td>'.$data['bride_first_name'].' '.$data['bride_last_name'].'</td>
                                <td>'.$data['groom_first_name'].' '.$data['groom_last_name'].'</td>
                                <td>'.$data['admin_email'].'</td>
                                <td>'.$data['wedding_date'].'</td>
                                <td>'.$data['city'].'</td>
                                <td>'.$data['state'].'</td>
                                <td>'.$data['country'].'</td>
                            </tr>
                        ';
                    }
                echo '</table>';   
            }elseif($btnBulk == 'edit'){
                return $this->redirect(['weddings/edit?id='.$selection[0]]);
            }
        }elseif(count($selection) == 0 && $btnBulk == 'download'){
            $weddingModel= Wedding::find()->all();
            $filename = 'Data-'.Date('YmdGis').'-Wedding.xls';
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=".$filename);
            echo '<table border="1" width="100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Bride</th>
                        <th>Groom</th>
                        <th>Email</th>
                        <th>Wedding Date</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>
                    </tr>
                </thead>';
                foreach($weddingModel as $data){
                    echo '
                        <tr>
                            <td>'.$data['id'].'</td>
                            <td>'.$data['bride_first_name'].' '.$data['bride_last_name'].'</td>
                            <td>'.$data['groom_first_name'].' '.$data['groom_last_name'].'</td>
                            <td>'.$data['admin_email'].'</td>
                            <td>'.$data['wedding_date'].'</td>
                            <td>'.$data['city'].'</td>
                            <td>'.$data['state'].'</td>
                            <td>'.$data['country'].'</td>
                        </tr>
                    ';
                }
            echo '</table>'; 
        }
        if($btnBulk == 'delete'){
            return $this->redirect(['weddings/index']);
        }
    }
}