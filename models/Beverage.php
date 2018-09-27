<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "beverage".
 *
 * @property integer $id
 * @property string $name
 * @property string $ingredients
 * @property string $instructions
 * @property integer $type_id
 *
 * @property BeverageType $type
 * @property BeverageAlcohol[] $beverageAlcohols
 * @property BeverageLike[] $beverageLikes
 * @property BeverageMixer[] $beverageMixers
 * @property Mixer[] $mixers
 */
class Beverage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'beverage';
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
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => BeverageType::className(), 'targetAttribute' => ['type_id' => 'id']],
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
    public function getType()
    {
        return $this->hasOne(BeverageType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeverageAlcohols()
    {
        return $this->hasMany(BeverageAlcohol::className(), ['beverage_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeverageLikes()
    {
        return $this->hasMany(BeverageLike::className(), ['beverage_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeverageMixers()
    {
        return $this->hasMany(BeverageMixer::className(), ['beverage_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMixers()
    {
        return $this->hasMany(Mixer::className(), ['id' => 'mixer_id'])->viaTable('beverage_mixer', ['beverage_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return BeverageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BeverageQuery(get_called_class());
    }
}
