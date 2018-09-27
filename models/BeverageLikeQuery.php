<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[BeverageLike]].
 *
 * @see BeverageLike
 */
class BeverageLikeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    public function forWedding($weddingId)
    {
        $this->joinWith('guest');
        $this->andWhere(['guest.wedding_id' => $weddingId]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return BeverageLike[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BeverageLike|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
