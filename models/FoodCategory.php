<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "food_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $vanity_url
 * @property integer $wedding_id
 * @property integer $order
 *
 * @property Food[] $foods
 * @property Wedding $wedding
 */
class FoodCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'food_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'vanity_url', 'wedding_id'], 'required'],
            [['wedding_id', 'order'], 'integer'],
            [['name', 'vanity_url'], 'string', 'max' => 255],
            [['wedding_id'], 'exist', 'skipOnError' => true, 'targetClass' => Wedding::className(), 'targetAttribute' => ['wedding_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'vanity_url' => Yii::t('app', 'Vanity Url'),
            'wedding_id' => Yii::t('app', 'Wedding ID'),
            'order' => Yii::t('app', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoods()
    {
        return $this->hasMany(Food::className(), ['food_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWedding()
    {
        return $this->hasOne(Wedding::className(), ['id' => 'wedding_id']);
    }

    /**
     * @inheritdoc
     * @return FoodCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FoodCategoryQuery(get_called_class());
    }
}
