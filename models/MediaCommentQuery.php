<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MediaComment]].
 *
 * @see MediaComment
 */
class MediaCommentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return MediaComment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MediaComment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
