<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "song_like".
 *
 * @property integer $id
 * @property string $liked_at
 * @property integer $guest_id
 * @property integer $song_id
 *
 * @property Guest $guest
 * @property Song $song
 */
class SongLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'song_like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['liked_at', 'guest_id', 'song_id'], 'required'],
            [['liked_at'], 'safe'],
            [['guest_id', 'song_id'], 'integer'],
            [['guest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Guest::className(), 'targetAttribute' => ['guest_id' => 'id']],
            [['song_id'], 'exist', 'skipOnError' => true, 'targetClass' => Song::className(), 'targetAttribute' => ['song_id' => 'id']],
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
            'song_id' => Yii::t('app', 'Song ID'),
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
    public function getSong()
    {
        return $this->hasOne(Song::className(), ['id' => 'song_id']);
    }

    /**
     * @inheritdoc
     * @return SongLikeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SongLikeQuery(get_called_class());
    }
}
