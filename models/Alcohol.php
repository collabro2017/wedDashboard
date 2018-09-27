<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alcohol".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $wedding_id
 * @property integer $can_combine
 *
 * @property Alcohol $parent
 * @property Alcohol[] $alcohols
 * @property BeverageAlcohol[] $beverageAlcohols
 * @property WeddingDrink[] $weddingDrinks
 */
class Alcohol extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alcohol';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id', 'wedding_id', 'can_combine'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Alcohol::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'parent_id' => Yii::t('app', 'Parent ID'),
            'wedding_id' => Yii::t('app', 'Wedding ID'),
            'can_combine' => Yii::t('app', 'Can Combine'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Alcohol::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlcohols()
    {
        return $this->hasMany(Alcohol::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeverageAlcohols()
    {
        return $this->hasMany(BeverageAlcohol::className(), ['alcohol_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWeddingDrinks()
    {
        return $this->hasMany(WeddingDrink::className(), ['alcohol_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return AlcoholQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlcoholQuery(get_called_class());
    }
}
