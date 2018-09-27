<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "answer".
 *
 * @property integer $id
 * @property integer $question_id
 * @property string $body
 * @property integer $is_correct
 *
 * @property Question $question
 * @property TriviaAnswer[] $triviaAnswers
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'body'], 'required'],
            [['question_id', 'is_correct'], 'integer'],
            [['body'], 'string', 'max' => 255],
            [['question_id', 'body'], 'unique', 'targetAttribute' => ['question_id', 'body'], 'message' => 'The combination of Question ID and Body has already been taken.'],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'question_id' => Yii::t('app', 'Question ID'),
            'body' => Yii::t('app', 'Body'),
            'is_correct' => Yii::t('app', 'Is Correct'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTriviaAnswers()
    {
        return $this->hasMany(TriviaAnswer::className(), ['answer_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return AnswerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AnswerQuery(get_called_class());
    }
}
