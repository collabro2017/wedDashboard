<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "base_drink".
 *
 * @property integer $id
 * @property string $name
 * @property integer $can_combine
 *
 * @property AvailableDrink[] $availableDrinks
 * @property DrinkBrand[] $drinkBrands
 * @property ExistingDrinkBaseDrink[] $existingDrinkBaseDrinks
 * @property ExistingDrink[] $existingDrinks
 */
class BaseDrink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_drink';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['can_combine'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'can_combine' => Yii::t('app', 'Can Combine'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvailableDrinks()
    {
        return $this->hasMany(AvailableDrink::className(), ['base_drink_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrinkBrands()
    {
        return $this->hasMany(DrinkBrand::className(), ['base_drink_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExistingDrinkBaseDrinks()
    {
        return $this->hasMany(ExistingDrinkBaseDrink::className(), ['base_drink_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExistingDrinks()
    {
        return $this->hasMany(ExistingDrink::className(), ['id' => 'existing_drink_id'])->viaTable('existing_drink_base_drink', ['base_drink_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return BaseDrinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BaseDrinkQuery(get_called_class());
    }
}
