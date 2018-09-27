<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AvailableDrink]].
 *
 * @see AvailableDrink
 */
class AvailableDrinkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return AvailableDrink[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AvailableDrink|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
