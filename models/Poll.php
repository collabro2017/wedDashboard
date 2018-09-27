<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "poll".
 *
 * @property integer $id
 * @property string $topic
 * @property integer $wedding_id
 * @property integer $order
 * @property string $started_at
 * @property string $ended_at
 *
 * @property Wedding $wedding
 * @property PollOption[] $pollOptions
 */
class Poll extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poll';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topic', 'wedding_id'], 'required'],
            [['wedding_id', 'order'], 'integer'],
            [['started_at', 'ended_at'], 'safe'],
            [['topic'], 'string', 'max' => 255],
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
            'topic' => Yii::t('app', 'Topic'),
            'wedding_id' => Yii::t('app', 'Wedding ID'),
            'order' => Yii::t('app', 'Order'),
            'started_at' => Yii::t('app', 'Started At'),
            'ended_at' => Yii::t('app', 'Ended At'),
        ];
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
    public function getPollOptions()
    {
        return $this->hasMany(PollOption::className(), ['poll_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return PollQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PollQuery(get_called_class());
    }
}
