<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "beverage_like".
 *
 * @property integer $id
 * @property integer $beverage_id
 * @property integer $guest_id
 * @property string $liked_at
 *
 * @property Guest $guest
 * @property Beverage $beverage
 */
class BeverageLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'beverage_like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['beverage_id', 'guest_id'], 'required'],
            [['beverage_id', 'guest_id'], 'integer'],
            [['liked_at'], 'safe'],
            [['guest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Guest::className(), 'targetAttribute' => ['guest_id' => 'id']],
            [['beverage_id'], 'exist', 'skipOnError' => true, 'targetClass' => Beverage::className(), 'targetAttribute' => ['beverage_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'beverage_id' => Yii::t('app', 'Beverage ID'),
            'guest_id' => Yii::t('app', 'Guest ID'),
            'liked_at' => Yii::t('app', 'Liked At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuest()
    {
        return $this->hasOne(Guest::className(), ['id' => 'guest_id']);
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
     * @return BeverageLikeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BeverageLikeQuery(get_called_class());
    }
}
