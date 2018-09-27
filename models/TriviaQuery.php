<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Trivia]].
 *
 * @see Trivia
 */
class TriviaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Trivia[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Trivia|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
