<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[User]].
 * @see User
 */
/**
 * Class UserQuery
 * @package app\models
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function admins()
    {
        return $this->andWhere(['role' => ext\User::ROLE_ADMIN]);
    }

    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere('is_active = 1');
    }

    /**
     * @inheritdoc
     * @return User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
