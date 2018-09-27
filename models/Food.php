<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "food".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $order
 * @property integer $food_category_id
 *
 * @property FoodCategory $foodCategory
 */
class Food extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'food';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order', 'food_category_id'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
            [['food_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => FoodCategory::className(), 'targetAttribute' => ['food_category_id' => 'id']],
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
            'description' => Yii::t('app', 'Description'),
            'order' => Yii::t('app', 'Order'),
            'food_category_id' => Yii::t('app', 'Food Category ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoodCategory()
    {
        return $this->hasOne(FoodCategory::className(), ['id' => 'food_category_id']);
    }

    /**
     * @inheritdoc
     * @return FoodQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FoodQuery(get_called_class());
    }
}
