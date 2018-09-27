<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[DrinkType]].
 *
 * @see DrinkType
 */
class DrinkTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return DrinkType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DrinkType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
