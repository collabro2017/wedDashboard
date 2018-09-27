<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12/04/15
 * Time: 18:27
 */

namespace app\models\ext;

class Question extends \app\models\Question
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }

    public function beforeDelete()
    {
        $result = true;
        foreach ($this->answers as $answer) {
            $result = $result && $answer->delete();
        }

        return $result && parent::beforeDelete();
    }
}