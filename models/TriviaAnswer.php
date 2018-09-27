<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trivia_answer".
 *
 * @property integer $id
 * @property string $answered_at
 * @property integer $guest_id
 * @property integer $answer_id
 * @property integer $score
 *
 * @property Answer $answer
 * @property Guest $guest
 */
class TriviaAnswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trivia_answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answered_at', 'guest_id', 'answer_id'], 'required'],
            [['answered_at'], 'safe'],
            [['guest_id', 'answer_id', 'score'], 'integer'],
            [['answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Answer::className(), 'targetAttribute' => ['answer_id' => 'id']],
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
            'answered_at' => Yii::t('app', 'Answered At'),
            'guest_id' => Yii::t('app', 'Guest ID'),
            'answer_id' => Yii::t('app', 'Answer ID'),
            'score' => Yii::t('app', 'Score'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Answer::className(), ['id' => 'answer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuest()
    {
        return $this->hasOne(Guest::className(), ['id' => 'guest_id']);
    }

    /**
     * @inheritdoc
     * @return TriviaAnswerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TriviaAnswerQuery(get_called_class());
    }
}
