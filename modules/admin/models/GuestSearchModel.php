<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 14/11/2016
 * Time: 23:17
 */

namespace app\modules\admin\models;

use yii\base\Model;

use yii\data\ActiveDataProvider;

/**
 * Class GuestSearchModel
 * @package app\modules\admin\models
 */
class GuestSearchModel extends \app\models\Guest
{
    /**
     * @var
     */
    
    public $searchstring;

    /**
     * @return array
     */
    
    public function search($params){
        $array = array();
        $query = \app\models\Guest::find()->where('id is not null');
        if(isset($params['per-page'])){
            $pageSize = $params['per-page'];
        }else{
            $pageSize = 50;
        }
       
        if(!empty($params['q'])){
            $query->andFilterWhere(['or',
            ['like','first_name',$params['q']],
            ['like','last_name',$params['q']],
            ['like','email',$params['q']] ]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize
            ],
        ]);
         $dataProvider->setSort([
        'attributes' => [
            'first_name' => [
                'asc' => ['first_name' => SORT_ASC],
                'desc' => ['first_name' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'last_name' => [
                'asc' => ['last_name' => SORT_ASC],
                'desc' => ['last_name' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'code' => [
                'asc' => ['code' => SORT_ASC],
                'desc' => ['code' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'email' => [
                'asc' => ['email' => SORT_ASC],
                'desc' => ['email' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'wedding_date' => [
                'asc' => ['wedding_date' => SORT_ASC],
                'desc' => ['wedding_date' => SORT_DESC],
                'default' => SORT_ASC,
            ],
            'id' => [
                'asc' => ['id' => SORT_ASC],
                'desc' => ['id' => SORT_DESC],
                'default' => SORT_ASC,
            ],
        ],
        'defaultOrder' => [
            'first_name' => SORT_ASC
        ]
    ]);



        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}