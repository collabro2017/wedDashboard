<?php
namespace app\models\ext;

use app\models\TriviaLeaderboard;

class Trivia extends \app\models\Trivia
{
    public function getGuests($weddingId)
    {
        return TriviaLeaderboard::find()
            ->where([
                'trivia_id'  => $this->id,
                'wedding_id' => $weddingId
            ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['trivia_id' => 'id']);
    }

    public function beforeDelete()
    {
        $result = true;
        foreach ($this->questions as $question) {
            $result = $result && $question->delete();
        }

        return $result && parent::beforeDelete();
    }
}