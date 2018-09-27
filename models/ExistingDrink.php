<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "existing_drink".
 *
 * @property integer $id
 * @property string $name
 * @property string $ingredients
 * @property string $instructions
 * @property integer $type_id
 *
 * @property DrinkLike[] $drinkLikes
 * @property DrinkType $type
 * @property ExistingDrinkBaseDrink[] $existingDrinkBaseDrinks
 * @property BaseDrink[] $baseDrinks
 * @property ExistingDrinkBrand[] $existingDrinkBrands
 * @property DrinkBrand[] $drinkBrands
 * @property ExistingDrinkMixer[] $existingDrinkMixers
 * @property DrinkMixer[] $drinkMixers
 */
class ExistingDrink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'existing_drink';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ingredients', 'instructions'], 'string'],
            [['type_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => DrinkType::className(), 'targetAttribute' => ['type_id' => 'id']],
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
            'ingredients' => Yii::t('app', 'Ingredients'),
            'instructions' => Yii::t('app', 'Instructions'),
            'type_id' => Yii::t('app', 'Type ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrinkLikes()
    {
        return $this->hasMany(DrinkLike::className(), ['existing_drink_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(DrinkType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExistingDrinkBaseDrinks()
    {
        return $this->hasMany(ExistingDrinkBaseDrink::className(), ['existing_drink_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseDrinks()
    {
        return $this->hasMany(BaseDrink::className(), ['id' => 'base_drink_id'])->viaTable('existing_drink_base_drink', ['existing_drink_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExistingDrinkBrands()
    {
        return $this->hasMany(ExistingDrinkBrand::className(), ['existing_drink_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrinkBrands()
    {
        return $this->hasMany(DrinkBrand::className(), ['id' => 'drink_brand_id'])->viaTable('existing_drink_brand', ['existing_drink_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExistingDrinkMixers()
    {
        return $this->hasMany(ExistingDrinkMixer::className(), ['existing_drink_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrinkMixers()
    {
        return $this->hasMany(DrinkMixer::className(), ['id' => 'drink_mixer_id'])->viaTable('existing_drink_mixer', ['existing_drink_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ExistingDrinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExistingDrinkQuery(get_called_class());
    }
}
