<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ExistingDrinkBaseDrink]].
 *
 * @see ExistingDrinkBaseDrink
 */
class ExistingDrinkBaseDrinkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ExistingDrinkBaseDrink[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ExistingDrinkBaseDrink|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
