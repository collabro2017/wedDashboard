<?php

namespace app\models;
use yii2vm\db\ActiveQueryRandomTrait;

/**
 * This is the ActiveQuery class for [[Poll]].
 *
 * @see Poll
 */
class PollQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/
    use ActiveQueryRandomTrait;

    /**
     * @inheritdoc
     * @return Poll[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Poll|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
