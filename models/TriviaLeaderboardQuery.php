<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TriviaLeaderboard]].
 *
 * @see TriviaLeaderboard
 */
class TriviaLeaderboardQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TriviaLeaderboard[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TriviaLeaderboard|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
