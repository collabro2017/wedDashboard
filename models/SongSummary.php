<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "song_summary".
 *
 * @property integer $id
 * @property string $title
 * @property integer $guest_id
 * @property string $artist
 * @property string $cover_url
 * @property string $requested_at
 * @property string $first_name
 * @property string $last_name
 * @property integer $wedding_id
 * @property string $table
 * @property integer $likes
 */
class SongSummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'song_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'guest_id', 'wedding_id', 'likes'], 'integer'],
            [['title', 'guest_id', 'artist', 'requested_at'], 'required'],
            [['requested_at'], 'safe'],
            [['title', 'artist', 'cover_url', 'first_name', 'last_name', 'table'], 'string', 'max' => 255],
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
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'wedding_id' => Yii::t('app', 'Wedding ID'),
            'table' => Yii::t('app', 'Table'),
            'likes' => Yii::t('app', 'Likes'),
        ];
    }

    /**
     * @inheritdoc
     * @return SongSummaryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SongSummaryQuery(get_called_class());
    }
}
