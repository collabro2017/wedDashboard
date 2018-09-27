<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "beverage_alcohol".
 *
 * @property integer $beverage_id
 * @property integer $alcohol_id
 *
 * @property Alcohol $alcohol
 * @property Beverage $beverage
 */
class BeverageAlcohol extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'beverage_alcohol';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['beverage_id', 'alcohol_id'], 'required'],
            [['beverage_id', 'alcohol_id'], 'integer'],
            [['alcohol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Alcohol::className(), 'targetAttribute' => ['alcohol_id' => 'id']],
            [['beverage_id'], 'exist', 'skipOnError' => true, 'targetClass' => Beverage::className(), 'targetAttribute' => ['beverage_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'beverage_id' => Yii::t('app', 'Beverage ID'),
            'alcohol_id' => Yii::t('app', 'Alcohol ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlcohol()
    {
        return $this->hasOne(Alcohol::className(), ['id' => 'alcohol_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeverage()
    {
        return $this->hasOne(Beverage::className(), ['id' => 'beverage_id']);
    }

    /**
     * @inheritdoc
     * @return BeverageAlcoholQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BeverageAlcoholQuery(get_called_class());
    }
}
