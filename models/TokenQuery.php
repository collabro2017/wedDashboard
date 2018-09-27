<?php

namespace app\models;
use yii2vm\db\ActiveQueryRandomTrait;

/**
 * This is the ActiveQuery class for [[Token]].
 *
 * @see Token
 */
class TokenQuery extends \yii\db\ActiveQuery
{
    use ActiveQueryRandomTrait;

    /**
     * @inheritdoc
     * @return Token[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Token|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
