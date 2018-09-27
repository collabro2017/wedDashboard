<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "media_like".
 *
 * @property integer $id
 * @property string $liked_at
 * @property integer $guest_id
 * @property integer $media_id
 *
 * @property Guest $guest
 * @property Media $media
 */
class MediaLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'media_like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['liked_at'], 'safe'],
            [['guest_id', 'media_id'], 'required'],
            [['guest_id', 'media_id'], 'integer'],
            [['guest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Guest::className(), 'targetAttribute' => ['guest_id' => 'id']],
            [['media_id'], 'exist', 'skipOnError' => true, 'targetClass' => Media::className(), 'targetAttribute' => ['media_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'liked_at' => Yii::t('app', 'Liked At'),
            'guest_id' => Yii::t('app', 'Guest ID'),
            'media_id' => Yii::t('app', 'Media ID'),
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
    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id']);
    }

    /**
     * @inheritdoc
     * @return MediaLikeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MediaLikeQuery(get_called_class());
    }
}
