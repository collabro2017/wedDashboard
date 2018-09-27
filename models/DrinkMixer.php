<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "drink_mixer".
 *
 * @property integer $id
 * @property string $name
 *
 * @property ExistingDrinkMixer[] $existingDrinkMixers
 * @property ExistingDrink[] $existingDrinks
 */
class DrinkMixer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'drink_mixer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExistingDrinkMixers()
    {
        return $this->hasMany(ExistingDrinkMixer::className(), ['drink_mixer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExistingDrinks()
    {
        return $this->hasMany(ExistingDrink::className(), ['id' => 'existing_drink_id'])->viaTable('existing_drink_mixer', ['drink_mixer_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return DrinkMixerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DrinkMixerQuery(get_called_class());
    }
}
