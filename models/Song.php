<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "song".
 *
 * @property integer $id
 * @property string $title
 * @property integer $guest_id
 * @property string $artist
 * @property string $cover_url
 * @property string $requested_at
 *
 * @property Guest $guest
 * @property SongLike[] $songLikes
 */
class Song extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'song';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'guest_id', 'artist', 'requested_at'], 'required'],
            [['guest_id'], 'integer'],
            [['requested_at'], 'safe'],
            [['title', 'artist', 'cover_url'], 'string', 'max' => 255],
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
            'title' => Yii::t('app', 'Title'),
            'guest_id' => Yii::t('app', 'Guest ID'),
            'artist' => Yii::t('app', 'Artist'),
            'cover_url' => Yii::t('app', 'Cover Url'),
            'requested_at' => Yii::t('app', 'Requested At'),
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
    public function getSongLikes()
    {
        return $this->hasMany(SongLike::className(), ['song_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return SongQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SongQuery(get_called_class());
    }
}
