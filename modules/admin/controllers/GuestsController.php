<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15/11/2016
 * Time: 01:39
 */

namespace app\modules\admin\controllers;

use app\models\ext\Guest;
use app\modules\admin\components\Controller;
use yii\data\ActiveDataProvider;
use yii2vm\db\ActiveUtils;

use app\models\ext\Trivia;
/**
 * Class GuestsController
 * @package app\modules\admin\controllers
 */
class GuestsController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $weddingModel = new \app\modules\admin\models\GuestSearchModel();
        $dataProvider = $weddingModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $weddingModel,
        ]);
    }
    
    public function actionEdit($id)
    {
        $data = \app\models\Guest::findOne((int)$id);
        if ($data->load(\Yii::$app->request->post()) && $data->save()) {
            return $this->redirect(['guests/index']);
        };

        return $this->render('edit', [
            'model' => $data,
            'data' => $data,
        ]);
    }
    
    public function actionTest(){
        echo '<pre>';
        $guest = Guest::findOne([
            'email'      => 'aa@aa.com',
            'wedding_id' => 11
        ]);
        $test = [
            'guest' => ActiveUtils::toArray($guest, [], function (Guest $guest) {
                /** @noinspection PhpUndefinedFieldInspection */
                return [
                    'trivia'            => ActiveUtils::toArray($guest->getTrivia()->all(), [], function (Trivia $trivia) use
                    (
                        $guest
                    ) {
                        return [
                            'points' => (int)$guest->getPoints($trivia->id),
                            'ranked' => (int)$guest->getRank($trivia->id),
                            'of'     => (int)$guest->wedding->getGuests()->count(),
                        ];
                    }),
                    'songs_activity'    => [
                        'requested' => $guest->getSongs()->count(),
                        'liked'     => $guest->getSongLikes()->count(),
                    ],
                    'pictures_activity' => [
                        'uploaded'  => $guest->getPhotos()->count(),
                        'liked'     => $guest->getPhotoLikes()->count(),
                        'commented' => $guest->getPhotoComments()->count(),
                    ],
                    'video_activity'    => [
                        'uploaded'  => $guest->getVideo()->count(),
                        'liked'     => $guest->getVideoLikes()->count(),
                        'commented' => $guest->getVideoComments()->count(),
                    ],
                ];
            }),
        ];
        print_r($test);
        exit;
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
                    $e= Guest::findOne((int)$id);//make a typecasting
                    $e->delete();
                }
                $command = $connection->createCommand("SET foreign_key_checks = 1;")->execute();
            }elseif($btnBulk == 'download'){
                $filename = 'Data-'.Date('YmdGis').'-Guest.xls';
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=".$filename);
                echo '<table border="1" width="100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Guest Name</th>
                            <th>Email</th>
                            <th>Table</th>
                            <th>With Who</th>
                            <th>Who Met First</th>
                            <th>How Know</th>
                        </tr>
                    </thead>';
                    foreach($selection as $id){
                    $data= Guest::findOne((int)$id);
                        echo '
                            <tr>
                                <td>'.$data['id'].'</td>
                                <td>'.$data['first_name'].' '.$data['last_name'].'</td>
                                <td>'.$data['email'].'</td>
                                <td>'.$data['table'].'</td>
                                <td>'.$data['with_who'].'</td>
                                <td>'.$data['who_met_first'].'</td>
                                <td>'.$data['how_know'].'</td>
                            </tr>
                        ';
                    }
                echo '</table>';   
            }elseif($btnBulk == 'edit'){
                return $this->redirect(['guests/edit?id='.$selection[0]]);
            }
        }elseif(count($selection) == 0 && $btnBulk == 'download'){
            $guestModel= Guest::find()->all();
            $filename = 'Data-'.Date('YmdGis').'-Guest.xls';
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=".$filename);
            echo '<table border="1" width="100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Guest Name</th>
                        <th>Email</th>
                        <th>Table</th>
                        <th>With Who</th>
                        <th>Who Met First</th>
                        <th>How Know</th>
                    </tr>
                </thead>';
                foreach($guestModel as $data){
                    echo '
                        <tr>
                            <td>'.$data['id'].'</td>
                            <td>'.$data['first_name'].' '.$data['last_name'].'</td>
                            <td>'.$data['email'].'</td>
                            <td>'.$data['table'].'</td>
                            <td>'.$data['with_who'].'</td>
                            <td>'.$data['who_met_first'].'</td>
                            <td>'.$data['how_know'].'</td>
                        </tr>
                    ';
                }
            echo '</table>'; 
        }
        if($btnBulk == 'delete'){
            return $this->redirect(['guests/index']);
        }
    }
    
}