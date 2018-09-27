<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wedding_drink".
 *
 * @property integer $id
 * @property integer $drink_category_id
 * @property integer $order
 * @property integer $alcohol_id
 *
 * @property DrinkCategory $drinkCategory
 * @property Alcohol $alcohol
 */
class WeddingDrink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wedding_drink';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['drink_category_id'], 'required'],
            [['drink_category_id', 'order', 'alcohol_id'], 'integer'],
            [['drink_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DrinkCategory::className(), 'targetAttribute' => ['drink_category_id' => 'id']],
            [['alcohol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Alcohol::className(), 'targetAttribute' => ['alcohol_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'drink_category_id' => Yii::t('app', 'Drink Category ID'),
            'order' => Yii::t('app', 'Order'),
            'alcohol_id' => Yii::t('app', 'Alcohol ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrinkCategory()
    {
        return $this->hasOne(DrinkCategory::className(), ['id' => 'drink_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlcohol()
    {
        return $this->hasOne(Alcohol::className(), ['id' => 'alcohol_id']);
    }

    /**
     * @inheritdoc
     * @return WeddingDrinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WeddingDrinkQuery(get_called_class());
    }
}
