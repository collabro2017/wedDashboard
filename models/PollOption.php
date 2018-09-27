<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "poll_option".
 *
 * @property integer $id
 * @property integer $poll_id
 * @property string $body
 *
 * @property GuestPollOption[] $guestPollOptions
 * @property Poll $poll
 */
class PollOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poll_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['poll_id', 'body'], 'required'],
            [['poll_id'], 'integer'],
            [['body'], 'string', 'max' => 255],
            [['poll_id', 'body'], 'unique', 'targetAttribute' => ['poll_id', 'body'], 'message' => 'The combination of Poll ID and Body has already been taken.'],
            [['poll_id'], 'exist', 'skipOnError' => true, 'targetClass' => Poll::className(), 'targetAttribute' => ['poll_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'poll_id' => Yii::t('app', 'Poll ID'),
            'body' => Yii::t('app', 'Body'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuestPollOptions()
    {
        return $this->hasMany(GuestPollOption::className(), ['poll_option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoll()
    {
        return $this->hasOne(Poll::className(), ['id' => 'poll_id']);
    }

    /**
     * @inheritdoc
     * @return PollOptionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PollOptionQuery(get_called_class());
    }
}
