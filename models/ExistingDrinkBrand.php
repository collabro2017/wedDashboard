<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "existing_drink_brand".
 *
 * @property integer $existing_drink_id
 * @property integer $drink_brand_id
 *
 * @property DrinkBrand $drinkBrand
 * @property ExistingDrink $existingDrink
 */
class ExistingDrinkBrand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'existing_drink_brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['existing_drink_id', 'drink_brand_id'], 'required'],
            [['existing_drink_id', 'drink_brand_id'], 'integer'],
            [['drink_brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => DrinkBrand::className(), 'targetAttribute' => ['drink_brand_id' => 'id']],
            [['existing_drink_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExistingDrink::className(), 'targetAttribute' => ['existing_drink_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'existing_drink_id' => Yii::t('app', 'Existing Drink ID'),
            'drink_brand_id' => Yii::t('app', 'Drink Brand ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrinkBrand()
    {
        return $this->hasOne(DrinkBrand::className(), ['id' => 'drink_brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExistingDrink()
    {
        return $this->hasOne(ExistingDrink::className(), ['id' => 'existing_drink_id']);
    }

    /**
     * @inheritdoc
     * @return ExistingDrinkBrandQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExistingDrinkBrandQuery(get_called_class());
    }
}
