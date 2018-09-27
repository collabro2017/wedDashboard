<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ExistingDrinkMixer]].
 *
 * @see ExistingDrinkMixer
 */
class ExistingDrinkMixerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ExistingDrinkMixer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ExistingDrinkMixer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
