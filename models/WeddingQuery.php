<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Wedding]].
 * @see Wedding
 */
/**
 * Class WeddingQuery
 * @package app\models
 */
class WeddingQuery extends \yii\db\ActiveQuery
{
    public function forGuest($guest)
    {
        return $this->rightJoin([
            'guests' => Guest::find()->andWhere(['email' => $guest->email]),
        ], 'guests.wedding_id = wedding.id')
                    ->andWhere('wedding.id is not null')
                    ->orderBy('wedding_date asc');
    }

    /**
     * @inheritdoc
     * @return Wedding[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Wedding|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
