<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "guest".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $table
 * @property integer $wedding_id
 * @property string $with_who
 * @property string $who_met_first
 * @property string $how_know
 * @property string $image_filename
 * @property string $created_at
 * @property string $device_token
 *
 * @property DrinkLike[] $drinkLikes
 * @property Wedding $wedding
 * @property GuestPollOption[] $guestPollOptions
 * @property Media[] $media
 * @property MediaComment[] $mediaComments
 * @property MediaGuest[] $mediaGuests
 * @property Media[] $media0
 * @property MediaLike[] $mediaLikes
 * @property Song[] $songs
 * @property SongLike[] $songLikes
 * @property Token[] $tokens
 * @property TriviaAnswer[] $triviaAnswers
 */
class Guest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'table', 'wedding_id', 'created_at'], 'required'],
            [['wedding_id'], 'integer'],
            [['with_who', 'who_met_first', 'how_know'], 'string'],
            [['created_at'], 'safe'],
            [['first_name', 'last_name', 'email', 'table'], 'string', 'max' => 255],
            [['image_filename'], 'string', 'max' => 45],
            [['device_token'], 'string', 'max' => 64],
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
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'table' => Yii::t('app', 'Table'),
            'wedding_id' => Yii::t('app', 'Wedding ID'),
            'with_who' => Yii::t('app', 'With Who'),
            'who_met_first' => Yii::t('app', 'Who Met First'),
            'how_know' => Yii::t('app', 'How Know'),
            'image_filename' => Yii::t('app', 'Image Filename'),
            'created_at' => Yii::t('app', 'Created At'),
            'device_token' => Yii::t('app', 'Device Token'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrinkLikes()
    {
        return $this->hasMany(DrinkLike::className(), ['guest_id' => 'id']);
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
    public function getGuestPollOptions()
    {
        return $this->hasMany(GuestPollOption::className(), ['guest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['guest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaComments()
    {
        return $this->hasMany(MediaComment::className(), ['guest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaGuests()
    {
        return $this->hasMany(MediaGuest::className(), ['guest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia0()
    {
        return $this->hasMany(Media::className(), ['id' => 'media_id'])->viaTable('media_guest', ['guest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaLikes()
    {
        return $this->hasMany(MediaLike::className(), ['guest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSongs()
    {
        return $this->hasMany(Song::className(), ['guest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSongLikes()
    {
        return $this->hasMany(SongLike::className(), ['guest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTokens()
    {
        return $this->hasMany(Token::className(), ['guest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTriviaAnswers()
    {
        return $this->hasMany(TriviaAnswer::className(), ['guest_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return GuestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GuestQuery(get_called_class());
    }
}
