<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "available_drink".
 *
 * @property integer $id
 * @property integer $base_drink_id
 * @property integer $drink_brand_id
 * @property string $exclusive_brand_name
 * @property integer $drink_category_id
 * @property integer $order
 *
 * @property BaseDrink $baseDrink
 * @property DrinkCategory $drinkCategory
 * @property DrinkBrand $drinkBrand
 */
class AvailableDrink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'available_drink';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['base_drink_id', 'drink_category_id'], 'required'],
            [['base_drink_id', 'drink_brand_id', 'drink_category_id', 'order'], 'integer'],
            [['exclusive_brand_name'], 'string', 'max' => 255],
            [['base_drink_id'], 'exist', 'skipOnError' => true, 'targetClass' => BaseDrink::className(), 'targetAttribute' => ['base_drink_id' => 'id']],
            [['drink_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DrinkCategory::className(), 'targetAttribute' => ['drink_category_id' => 'id']],
            [['drink_brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => DrinkBrand::className(), 'targetAttribute' => ['drink_brand_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'base_drink_id' => Yii::t('app', 'Base Drink ID'),
            'drink_brand_id' => Yii::t('app', 'Drink Brand ID'),
            'exclusive_brand_name' => Yii::t('app', 'Exclusive Brand Name'),
            'drink_category_id' => Yii::t('app', 'Drink Category ID'),
            'order' => Yii::t('app', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseDrink()
    {
        return $this->hasOne(BaseDrink::className(), ['id' => 'base_drink_id']);
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
    public function getDrinkBrand()
    {
        return $this->hasOne(DrinkBrand::className(), ['id' => 'drink_brand_id']);
    }

    /**
     * @inheritdoc
     * @return AvailableDrinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AvailableDrinkQuery(get_called_class());
    }
}
