<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MediaLike]].
 *
 * @see MediaLike
 */
class MediaLikeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return MediaLike[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MediaLike|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
