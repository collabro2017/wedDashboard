<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property integer $id
 * @property integer $trivia_id
 * @property string $topic
 * @property string $image_filename
 * @property integer $order
 *
 * @property Answer[] $answers
 * @property Trivia $trivia
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trivia_id'], 'required'],
            [['trivia_id', 'order'], 'integer'],
            [['topic'], 'string', 'max' => 512],
            [['image_filename'], 'string', 'max' => 45],
            [['trivia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trivia::className(), 'targetAttribute' => ['trivia_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'trivia_id' => Yii::t('app', 'Trivia ID'),
            'topic' => Yii::t('app', 'Topic'),
            'image_filename' => Yii::t('app', 'Image Filename'),
            'order' => Yii::t('app', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrivia()
    {
        return $this->hasOne(Trivia::className(), ['id' => 'trivia_id']);
    }

    /**
     * @inheritdoc
     * @return QuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestionQuery(get_called_class());
    }
}
