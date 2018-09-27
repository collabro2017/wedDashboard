<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "existing_drink_base_drink".
 *
 * @property integer $existing_drink_id
 * @property integer $base_drink_id
 *
 * @property BaseDrink $baseDrink
 * @property ExistingDrink $existingDrink
 */
class ExistingDrinkBaseDrink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'existing_drink_base_drink';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['existing_drink_id', 'base_drink_id'], 'required'],
            [['existing_drink_id', 'base_drink_id'], 'integer'],
            [['base_drink_id'], 'exist', 'skipOnError' => true, 'targetClass' => BaseDrink::className(), 'targetAttribute' => ['base_drink_id' => 'id']],
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
            'base_drink_id' => Yii::t('app', 'Base Drink ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseDrink()
    {
        return $this->hasOne(BaseDrink::className(), ['id' => 'base_drink_id']);
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
     * @return ExistingDrinkBaseDrinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExistingDrinkBaseDrinkQuery(get_called_class());
    }
}
