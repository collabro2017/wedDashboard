<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[WeddingDrink]].
 *
 * @see WeddingDrink
 */
class WeddingDrinkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return WeddingDrink[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return WeddingDrink|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
