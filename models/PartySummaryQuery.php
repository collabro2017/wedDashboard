<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PartySummary]].
 *
 * @see PartySummary
 */
class PartySummaryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return PartySummary[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PartySummary|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
