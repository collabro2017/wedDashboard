<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "drink_brand".
 *
 * @property integer $id
 * @property string $name
 * @property integer $base_drink_id
 *
 * @property AvailableDrink[] $availableDrinks
 * @property BaseDrink $baseDrink
 * @property ExistingDrinkBrand[] $existingDrinkBrands
 * @property ExistingDrink[] $existingDrinks
 */
class DrinkBrand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'drink_brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['base_drink_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['base_drink_id'], 'exist', 'skipOnError' => true, 'targetClass' => BaseDrink::className(), 'targetAttribute' => ['base_drink_id' => 'id']],
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
            'base_drink_id' => Yii::t('app', 'Base Drink ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvailableDrinks()
    {
        return $this->hasMany(AvailableDrink::className(), ['drink_brand_id' => 'id']);
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
    public function getExistingDrinkBrands()
    {
        return $this->hasMany(ExistingDrinkBrand::className(), ['drink_brand_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExistingDrinks()
    {
        return $this->hasMany(ExistingDrink::className(), ['id' => 'existing_drink_id'])->viaTable('existing_drink_brand', ['drink_brand_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return DrinkBrandQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DrinkBrandQuery(get_called_class());
    }
}
