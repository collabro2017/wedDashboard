<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MediaGuest]].
 *
 * @see MediaGuest
 */
class MediaGuestQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return MediaGuest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MediaGuest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
