<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[FoodCategory]].
 *
 * @see FoodCategory
 */
class FoodCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return FoodCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FoodCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
