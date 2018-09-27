<?php

namespace app\models;
use yii2vm\db\ActiveQueryRandomTrait;

/**
 * This is the ActiveQuery class for [[Media]].
 *
 * @see Media
 */
class MediaQuery extends \yii\db\ActiveQuery
{
    use ActiveQueryRandomTrait;

    /**
     * @inheritdoc
     * @return Media[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Media|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
