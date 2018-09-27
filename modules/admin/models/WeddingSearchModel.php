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
 * Class SignInModel
 * @package app\modules\admin\models
 */
class WeddingSearchModel extends \app\models\Wedding
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
        
//            ->andWhere(['id'=>$array])
//            ->andWhere(['is not', 'shop_price', null])
//            ->andWhere(['is not', 'main_category_id', null])
        $query = \app\models\Wedding::find()->where('id is not null');
        if(isset($params['per-page'])){
            $pageSize = $params['per-page'];
        }else{
            $pageSize = 50;
        }
       
        if(!empty($params['q'])){
            $query->andFilterWhere(['or',
            ['like','bride_first_name',$params['q']],
            ['like','bride_last_name',$params['q']],
            ['like','groom_first_name',$params['q']],
            ['like','groom_last_name',$params['q']],
            ['like','code',$params['q']],
            ['like','admin_email',$params['q']] ]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize
            ],
        ]);
         $dataProvider->setSort([
        'attributes' => [
            'bride_first_name' => [
                'asc' => ['bride_first_name' => SORT_ASC],
                'desc' => ['bride_first_name' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'groom_first_name' => [
                'asc' => ['groom_first_name' => SORT_ASC],
                'desc' => ['groom_first_name' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'code' => [
                'asc' => ['code' => SORT_ASC],
                'desc' => ['code' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'admin_email' => [
                'asc' => ['admin_email' => SORT_ASC],
                'desc' => ['admin_email' => SORT_DESC],
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
            'wedding_date' => SORT_ASC
        ]
    ]);



        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}