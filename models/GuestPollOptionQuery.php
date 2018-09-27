<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[GuestPollOption]].
 *
 * @see GuestPollOption
 */
class GuestPollOptionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return GuestPollOption[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return GuestPollOption|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
