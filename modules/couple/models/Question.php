<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13/04/15
 * Time: 13:20
 */

namespace app\modules\couple\models;

use yii\helpers\ArrayHelper;

/**
 * Class Question
 * @package app\modules\couple\models
 * @property Answer[] $wrongAnswers
 * @property Answer   $correctAnswer
 * @property Trivia   $trivia
 */
class Question extends \app\models\ext\Question
{
    /**
     *
     */
    const MAX_WRONG_ANSWERS = 3;

    /**
     * @var
     */
    public $image;

    /**
     * @return Answer|array|null|\yii\db\ActiveRecord
     */
    public function getCorrectAnswer()
    {
        $answer = $this->getAnswers()->where(['is_correct' => 1])->one();
        if (!$answer) {
            $answer              = new Answer();
            $answer->is_correct  = 1;
            $answer->question_id = $this->id;
        }

        return $answer;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getWrongAnswers()
    {
        $answers = $this->getAnswers()->where(['is_correct' => 0])->all();
        for ($index = count($answers); $index < self::MAX_WRONG_ANSWERS; $index++) {
            $answers[] = new Answer();
        }

        return $answers;
    }

    /**
     * @param Answer $correct
     * @param array  $wrong
     *
     * @return bool
     */
    public function setAnswers($correct, $wrong)
    {
        $correct->question_id = $this->id;

        return $this->setWrongAnswers($wrong) && $correct->save();
    }

    /**
     * @param $answers
     *
     * @return bool
     */
    public function setWrongAnswers($answers)
    {
        $result = true;

        /** @var Answer $answer */
        foreach ($answers as $answer) {
            if ($answer->isNewRecord) {
                if (strlen($answer->body) > 0) {
                    $answer->question_id = $this->id;
                    if ($result &= ($answer->save() && $answer->refresh())) {
                        $this->link('answers', $answer);
                    }
                } else {
                    continue;
                }
            } else {
                if (!strlen($answer->body)) {
                    $this->unlink('answers', $answer, true);
                } else {
                    $result &= $answer->save();
                }
            }
        }

        return $result;
    }

    /**
     *
     */
    public function getAnswersLabel()
    {
        $labels = ArrayHelper::getColumn($this->getAnswers()->orderBy('is_correct')->all(), 'body');
        echo count($labels) ? implode(', ', $labels) : 'No answers yet';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrivia()
    {
        return $this->hasOne(Trivia::className(), ['id' => 'trivia_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }

    /**
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->order = static::find()
                                 ->where([
                                     'trivia_id' => $this->trivia_id,
                                 ])
                                 ->count() + 1;
        }

        if (!strlen($this->image_filename)) {
            $this->image_filename = null;
        }

        return parent::beforeSave($insert);
    }
}