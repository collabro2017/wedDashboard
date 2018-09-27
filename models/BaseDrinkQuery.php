<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[BaseDrink]].
 *
 * @see BaseDrink
 */
class BaseDrinkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return BaseDrink[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BaseDrink|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
