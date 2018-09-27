<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "drink_like".
 *
 * @property integer $id
 * @property integer $existing_drink_id
 * @property integer $guest_id
 * @property string $liked_at
 *
 * @property ExistingDrink $existingDrink
 * @property Guest $guest
 */
class DrinkLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'drink_like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['existing_drink_id', 'guest_id'], 'required'],
            [['existing_drink_id', 'guest_id'], 'integer'],
            [['liked_at'], 'safe'],
            [['existing_drink_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExistingDrink::className(), 'targetAttribute' => ['existing_drink_id' => 'id']],
            [['guest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Guest::className(), 'targetAttribute' => ['guest_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'existing_drink_id' => Yii::t('app', 'Existing Drink ID'),
            'guest_id' => Yii::t('app', 'Guest ID'),
            'liked_at' => Yii::t('app', 'Liked At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExistingDrink()
    {
        return $this->hasOne(ExistingDrink::className(), ['id' => 'existing_drink_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuest()
    {
        return $this->hasOne(Guest::className(), ['id' => 'guest_id']);
    }

    /**
     * @inheritdoc
     * @return DrinkLikeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DrinkLikeQuery(get_called_class());
    }
}
