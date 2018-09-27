<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "token".
 *
 * @property integer $id
 * @property string $hash
 * @property integer $guest_id
 * @property string $created_at
 * @property integer $is_valid
 *
 * @property Guest $guest
 */
class Token extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hash', 'guest_id', 'created_at'], 'required'],
            [['guest_id', 'is_valid'], 'integer'],
            [['created_at'], 'safe'],
            [['hash'], 'string', 'max' => 45],
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
            'hash' => Yii::t('app', 'Hash'),
            'guest_id' => Yii::t('app', 'Guest ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'is_valid' => Yii::t('app', 'Is Valid'),
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
     * @inheritdoc
     * @return TokenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TokenQuery(get_called_class());
    }
}
