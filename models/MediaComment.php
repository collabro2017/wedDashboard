<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "media_comment".
 *
 * @property integer $id
 * @property string $created_at
 * @property integer $guest_id
 * @property integer $media_id
 * @property string $body
 *
 * @property Guest $guest
 * @property Media $media
 */
class MediaComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'media_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['guest_id', 'media_id', 'body'], 'required'],
            [['guest_id', 'media_id'], 'integer'],
            [['body'], 'string'],
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
            'created_at' => Yii::t('app', 'Created At'),
            'guest_id' => Yii::t('app', 'Guest ID'),
            'media_id' => Yii::t('app', 'Media ID'),
            'body' => Yii::t('app', 'Body'),
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
     * @return MediaCommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MediaCommentQuery(get_called_class());
    }
}
