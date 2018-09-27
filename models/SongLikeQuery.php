<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SongLike]].
 *
 * @see SongLike
 */
class SongLikeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SongLike[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SongLike|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
