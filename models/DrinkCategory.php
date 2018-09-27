<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "drink_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $wedding_id
 * @property integer $order
 *
 * @property Wedding $wedding
 * @property WeddingDrink[] $weddingDrinks
 */
class DrinkCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'drink_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'wedding_id'], 'required'],
            [['wedding_id', 'order'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['wedding_id'], 'exist', 'skipOnError' => true, 'targetClass' => Wedding::className(), 'targetAttribute' => ['wedding_id' => 'id']],
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
            'wedding_id' => Yii::t('app', 'Wedding ID'),
            'order' => Yii::t('app', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWedding()
    {
        return $this->hasOne(Wedding::className(), ['id' => 'wedding_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWeddingDrinks()
    {
        return $this->hasMany(WeddingDrink::className(), ['drink_category_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return DrinkCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DrinkCategoryQuery(get_called_class());
    }
}
