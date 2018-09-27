<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[DrinkLike]].
 *
 * @see DrinkLike
 */
class DrinkLikeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return DrinkLike[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DrinkLike|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
