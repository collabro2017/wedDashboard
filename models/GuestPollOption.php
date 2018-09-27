<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "guest_poll_option".
 *
 * @property integer $id
 * @property integer $guest_id
 * @property integer $poll_option_id
 * @property string $polled_at
 *
 * @property Guest $guest
 * @property PollOption $pollOption
 */
class GuestPollOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guest_poll_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guest_id', 'poll_option_id', 'polled_at'], 'required'],
            [['guest_id', 'poll_option_id'], 'integer'],
            [['polled_at'], 'safe'],
            [['guest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Guest::className(), 'targetAttribute' => ['guest_id' => 'id']],
            [['poll_option_id'], 'exist', 'skipOnError' => true, 'targetClass' => PollOption::className(), 'targetAttribute' => ['poll_option_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'guest_id' => Yii::t('app', 'Guest ID'),
            'poll_option_id' => Yii::t('app', 'Poll Option ID'),
            'polled_at' => Yii::t('app', 'Polled At'),
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
    public function getPollOption()
    {
        return $this->hasOne(PollOption::className(), ['id' => 'poll_option_id']);
    }

    /**
     * @inheritdoc
     * @return GuestPollOptionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GuestPollOptionQuery(get_called_class());
    }
}
