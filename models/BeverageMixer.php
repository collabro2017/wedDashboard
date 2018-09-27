<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "beverage_mixer".
 *
 * @property integer $beverage_id
 * @property integer $mixer_id
 *
 * @property Mixer $mixer
 * @property Beverage $beverage
 */
class BeverageMixer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'beverage_mixer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['beverage_id', 'mixer_id'], 'required'],
            [['beverage_id', 'mixer_id'], 'integer'],
            [['mixer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mixer::className(), 'targetAttribute' => ['mixer_id' => 'id']],
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
            'mixer_id' => Yii::t('app', 'Mixer ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMixer()
    {
        return $this->hasOne(Mixer::className(), ['id' => 'mixer_id']);
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
     * @return BeverageMixerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BeverageMixerQuery(get_called_class());
    }
}
