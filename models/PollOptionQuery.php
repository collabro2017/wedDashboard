<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PollOption]].
 *
 * @see PollOption
 */
class PollOptionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return PollOption[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PollOption|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
