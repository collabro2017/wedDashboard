<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "media_guest".
 *
 * @property integer $guest_id
 * @property integer $media_id
 * @property double $tag_x
 * @property double $tag_y
 *
 * @property Guest $guest
 * @property Media $media
 */
class MediaGuest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'media_guest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guest_id', 'media_id'], 'required'],
            [['guest_id', 'media_id'], 'integer'],
            [['tag_x', 'tag_y'], 'number'],
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
            'guest_id' => Yii::t('app', 'Guest ID'),
            'media_id' => Yii::t('app', 'Media ID'),
            'tag_x' => Yii::t('app', 'Tag X'),
            'tag_y' => Yii::t('app', 'Tag Y'),
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
     * @return MediaGuestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MediaGuestQuery(get_called_class());
    }
}
