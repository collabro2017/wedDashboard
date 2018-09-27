<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SongSummary]].
 *
 * @see SongSummary
 */
class SongSummaryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SongSummary[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SongSummary|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
