<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Alcohol]].
 *
 * @see Alcohol
 */
class AlcoholQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Alcohol[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Alcohol|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function withoutBrand()
    {
        return $this->andWhere('parent_id is null');
    }

    public function withBrand()
    {
        return $this->andWhere('parent_id not null');
    }

    public function common()
    {
        return $this->andWhere('wedding_id is null');
    }
}
