<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "media".
 *
 * @property integer $id
 * @property string $kind
 * @property string $content_filename
 * @property string $content_thumbnail
 * @property integer $guest_id
 * @property string $caption
 * @property string $created_at
 *
 * @property Guest $guest
 * @property MediaComment[] $mediaComments
 * @property MediaGuest[] $mediaGuests
 * @property Guest[] $guests
 * @property MediaLike[] $mediaLikes
 */
class Media extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kind'], 'string'],
            [['guest_id'], 'required'],
            [['guest_id'], 'integer'],
            [['created_at'], 'safe'],
            [['content_filename', 'content_thumbnail'], 'string', 'max' => 255],
            [['caption'], 'string', 'max' => 1024],
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
            'kind' => Yii::t('app', 'Kind'),
            'content_filename' => Yii::t('app', 'Content Filename'),
            'content_thumbnail' => Yii::t('app', 'Content Thumbnail'),
            'guest_id' => Yii::t('app', 'Guest ID'),
            'caption' => Yii::t('app', 'Caption'),
            'created_at' => Yii::t('app', 'Created At'),
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
    public function getMediaComments()
    {
        return $this->hasMany(MediaComment::className(), ['media_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaGuests()
    {
        return $this->hasMany(MediaGuest::className(), ['media_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuests()
    {
        return $this->hasMany(Guest::className(), ['id' => 'guest_id'])->viaTable('media_guest', ['media_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaLikes()
    {
        return $this->hasMany(MediaLike::className(), ['media_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return MediaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MediaQuery(get_called_class());
    }
}
