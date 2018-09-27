<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "drink_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $image_filename
 *
 * @property ExistingDrink[] $existingDrinks
 */
class DrinkType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'drink_type';
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
    public function getExistingDrinks()
    {
        return $this->hasMany(ExistingDrink::className(), ['type_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return DrinkTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DrinkTypeQuery(get_called_class());
    }
}
