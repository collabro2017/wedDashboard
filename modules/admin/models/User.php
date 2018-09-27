<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21/11/2016
 * Time: 20:16
 */

namespace app\modules\admin\models;

use yii\web\IdentityInterface;

class User extends \app\models\ext\User implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return User::find()->active()->andWhere(['id' => $id])->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return User::find()->active()->andWhere(['access_token' => $token])->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->access_token;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() == $authKey && $this->is_active;
    }
    
    public function search($params){
        $array = array();
        $query = \app\models\User::find()->where('id is not null');
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
        
        $dataProvider = new \yii\data\ActiveDataProvider([
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
            'role' => [
                'asc' => ['role' => SORT_ASC],
                'desc' => ['role' => SORT_DESC],
                'default' => SORT_ASC
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