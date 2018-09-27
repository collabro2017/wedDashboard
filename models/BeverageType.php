<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "beverage_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $image_filename
 *
 * @property Beverage[] $beverages
 */
class BeverageType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'beverage_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'image_filename'], 'string', 'max' => 255],
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
            'image_filename' => Yii::t('app', 'Image Filename'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeverages()
    {
        return $this->hasMany(Beverage::className(), ['type_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return BeverageTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BeverageTypeQuery(get_called_class());
    }
}
