<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mixer".
 *
 * @property integer $id
 * @property string $name
 *
 * @property BeverageMixer[] $beverageMixers
 * @property Beverage[] $beverages
 */
class Mixer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mixer';
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
    public function getBeverageMixers()
    {
        return $this->hasMany(BeverageMixer::className(), ['mixer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeverages()
    {
        return $this->hasMany(Beverage::className(), ['id' => 'beverage_id'])->viaTable('beverage_mixer', ['mixer_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return MixerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MixerQuery(get_called_class());
    }
}
