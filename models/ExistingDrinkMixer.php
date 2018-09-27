<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "existing_drink_mixer".
 *
 * @property integer $existing_drink_id
 * @property integer $drink_mixer_id
 *
 * @property DrinkMixer $drinkMixer
 * @property ExistingDrink $existingDrink
 */
class ExistingDrinkMixer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'existing_drink_mixer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['existing_drink_id', 'drink_mixer_id'], 'required'],
            [['existing_drink_id', 'drink_mixer_id'], 'integer'],
            [['drink_mixer_id'], 'exist', 'skipOnError' => true, 'targetClass' => DrinkMixer::className(), 'targetAttribute' => ['drink_mixer_id' => 'id']],
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
            'drink_mixer_id' => Yii::t('app', 'Drink Mixer ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrinkMixer()
    {
        return $this->hasOne(DrinkMixer::className(), ['id' => 'drink_mixer_id']);
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
     * @return ExistingDrinkMixerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExistingDrinkMixerQuery(get_called_class());
    }
}
